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
use NetworkRailBusinessSystems\Common\Mail\StripStaleUser;
use NetworkRailBusinessSystems\Common\Models\User;

class StripStaleUsers implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(): void
    {
        /** @var class-string<User> $userClass */
        $userClass = config('common.models.user');

        $userClass::query()
            ->goneStale(
                Carbon::today()->subMonths($userClass::STALE_CUTOFF_MONTHS),
            )
            ->each(function ($user) {
                /** @var User $user */
                $user->roles()->delete();

                Mail::queue(new StripStaleUser($user));
            });
    }
}
