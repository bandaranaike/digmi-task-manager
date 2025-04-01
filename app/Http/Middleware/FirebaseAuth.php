<?php

namespace App\Http\Middleware;

use App\Services\FirebaseService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $idToken = $request->header('Authorization');

        if (!$idToken) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $firebaseService = new FirebaseService();
        $claims = $firebaseService->verifyIdToken(str_replace('Bearer ', '', $idToken));

        if (!$claims) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->attributes->add(['firebase_user' => $claims]);

        return $next($request);
    }
}
