<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Employ;
use App\Models\Company;

class DecodeTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            $user = JWTAuth::parseToken()->authenticate();

            $employe = Employ::where("user_id", $user->id)->first();
            if ($employe) {
                $company = Company::where("id", $employe->company_id)->first();

                $request->merge([
                    'employee_id' => $employe->id,
                    'company_id' => $company->id
                ]);

                return $next($request);
            } else {
                return response()->json(['error' => 'Employee not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token invalid or expired'], 401);
        }
    }
}
