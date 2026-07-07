<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Jobs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use NetworkRailBusinessSystems\Common\Jobs\StripStaleUsers;
use NetworkRailBusinessSystems\Common\Mail\StripStaleUser;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class StripStaleUsersTest extends TestCase
{
    protected StripStaleUsers $job;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        Mail::fake();

        $this->user = User::factory()
            ->withRole(Role::Admin)
            ->create([
                'updated_at' => Carbon::today()
                    ->subMonths(User::STALE_CUTOFF_MONTHS),
            ]);

        $this->job = new StripStaleUsers();
        $this->job->handle();
    }

    public function test(): void
    {
        $this->assertFalse(
            $this->user->roles()->exists(),
        );

        Mail::assertQueued(
            StripStaleUser::class,
            function (StripStaleUser $mail) {
                return $mail->user->is($this->user) === true;
            },
        );
    }
}
