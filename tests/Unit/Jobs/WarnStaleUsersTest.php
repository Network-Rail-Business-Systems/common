<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Jobs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use NetworkRailBusinessSystems\Common\Jobs\WarnStaleUsers;
use NetworkRailBusinessSystems\Common\Mail\WarnStaleUser;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class WarnStaleUsersTest extends TestCase
{
    protected WarnStaleUsers $job;

    protected User $firstWarn;

    protected User $finalWarn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        Mail::fake();

        $this->firstWarn = User::factory()
            ->withRole(Role::Admin)
            ->create([
                'updated_at' => Carbon::today()
                    ->subMonths(User::STALE_CUTOFF_MONTHS)
                    ->addMonth(),
            ]);

        $this->finalWarn = User::factory()
            ->withRole(Role::Admin)
            ->create([
                'updated_at' => Carbon::today()
                    ->subMonths(User::STALE_CUTOFF_MONTHS)
                    ->addWeek(),
            ]);

        $this->job = new WarnStaleUsers();
        $this->job->handle();
    }

    public function test(): void
    {
        Mail::assertQueued(
            WarnStaleUser::class,
            function (WarnStaleUser $mail) {
                return $mail->user->is($this->firstWarn) === true;
            },
        );

        Mail::assertQueued(
            WarnStaleUser::class,
            function (WarnStaleUser $mail) {
                return $mail->user->is($this->finalWarn) === true;
            },
        );
    }
}
