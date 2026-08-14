<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Builders\Users;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class GoneStaleTest extends TestCase
{
    protected Collection $expected;

    protected Collection $unexpected;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->expected = new Collection([
            User::factory()
                ->withRole(Role::Admin)
                ->create([
                    'updated_at' => Carbon::today(),
                ]),
            User::factory()
                ->withRole(Role::Admin)
                ->create([
                    'updated_at' => Carbon::today()->midDay(),
                ]),
            User::factory()
                ->withRole(Role::Admin)
                ->create([
                    'updated_at' => Carbon::today()->endOfDay(),
                ]),
            User::factory()
                ->withRole(Role::Admin)
                ->create([
                    'updated_at' => Carbon::yesterday(),
                ]),
        ]);

        $this->unexpected = new Collection([
            User::factory()
                ->withRole(Role::Admin)
                ->create([
                    'updated_at' => Carbon::today()
                        ->endOfDay()
                        ->addSecond(),
                ]),
            User::factory()
                ->withRole(Role::Admin)
                ->create([
                    'updated_at' => Carbon::tomorrow(),
                ]),
            User::factory()
                ->create([
                    'updated_at' => Carbon::yesterday(),
                ]),
        ]);
    }

    public function test(): void
    {
        $this->assertResultsMatch(
            User::query()
                ->goneStale(Carbon::today())
                ->get(),
            $this->expected,
            $this->unexpected,
        );
    }
}
