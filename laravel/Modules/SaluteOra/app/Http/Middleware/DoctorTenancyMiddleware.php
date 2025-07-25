<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware that conditionally applies tenancy only for doctor users.
 * For non-doctor users, it disables tenancy requirements.
 */
class DoctorTenancyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // If user is authenticated but is not a doctor, disable tenancy requirements
        if ($user && $user->type !== UserTypeEnum::DOCTOR) {
            // Mark in the session that this user should bypass tenant requirements
            session(['filament.tenant.bypass' => true]);
        }
        
        return $next($request);
    }
}
