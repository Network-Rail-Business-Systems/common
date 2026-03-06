<?php

namespace NetworkRailBusinessSystems\Common\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use NetworkRailBusinessSystems\Common\Models\User;

class ProtectNonGetRequests
{
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->method() !== 'GET') {
            /** @var ?User $user */
            $user = $request->user();

            if ($user !== null) {
                if ($user->isImpersonated() === true) {
                    throw new AuthorizationException(
                        'You cannot perform this action while impersonating another User',
                        403,
                    );
                }
            }
        }

        return $next($request);
    }
}
