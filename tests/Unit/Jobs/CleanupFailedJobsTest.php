<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Jobs;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use NetworkRailBusinessSystems\Common\Jobs\CleanupFailedJobs;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class CleanupFailedJobsTest extends TestCase
{
    protected CleanupFailedJobs $job;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        DB::table('failed_jobs')
            ->insert([
                [
                    'id' => 1,
                    'uuid' => '1',
                    'connection' => 'database',
                    'queue' => 'default',
                    'payload' => '',
                    'exception' => '',
                    'failed_at' => Carbon::now()->subWeek(),
                ],
                [
                    'id' => 2,
                    'uuid' => '2',
                    'connection' => 'database',
                    'queue' => 'default',
                    'payload' => '',
                    'exception' => '',
                    'failed_at' => Carbon::now(),
                ],
            ]);

        $this->job = new CleanupFailedJobs(12);
        $this->job->handle();
    }

    public function test(): void
    {
        $this->assertDatabaseMissing('failed_jobs', [
            'id' => 1,
        ]);

        $this->assertDatabaseHas('failed_jobs', [
            'id' => 2,
        ]);
    }
}
