<?php

namespace NetworkRailBusinessSystems\Common\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use NetworkRailBusinessSystems\Common\Mail\WarnStaleUser;
use NetworkRailBusinessSystems\Common\Models\User;

class WarnStaleUsers implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(): void
    {
        /** @var class-string<User> $userClass */
        $userClass = config('common.models.user');

        $cutoff = Carbon::today()->subMonths($userClass::STALE_CUTOFF_MONTHS);

        $userClass::query()
            ->goingStale(
                $cutoff->clone()->addMonth(),
            )
            ->each(function ($user) use ($cutoff) {
                Mail::queue(new WarnStaleUser($user, $cutoff));
            });

        $userClass::query()
            ->goingStale(
                $cutoff->clone()->addWeek(),
            )
            ->each(function ($user) use ($cutoff) {
                Mail::queue(new WarnStaleUser($user, $cutoff));
            });
    }
}
