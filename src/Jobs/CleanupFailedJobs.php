<?php

namespace NetworkRailBusinessSystems\Common\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CleanupFailedJobs implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected int $hours)
    {
        //
    }

    public function handle(): void
    {
        DB::table('failed_jobs')
            ->where(
                'failed_at',
                '<=',
                Carbon::now()->subHours($this->hours),
            )
            ->delete();
    }
}
