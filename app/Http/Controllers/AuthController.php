<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\Auth\AuthError;
use Kreait\Firebase\Exception\FirebaseException;

class AuthController extends Controller
{
    protected FirebaseService $firebaseService;

    public function __construct()
    {
        $this->firebaseService = new FirebaseService();
    }

    public function signIn(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        try {
            $auth = $this->firebaseService->getAuth();
            $signInResult = $auth->signInWithEmailAndPassword($request->get("email"), $request->get("password"));

            $idToken = $signInResult->idToken();

            return response()->json([
                'message' => 'Sign-in successful',
                'idToken' => $idToken,
            ]);
        } catch (AuthError|FirebaseException $e) {
            return response()->json(['message' => 'Invalid credentials', 'error' => $e->getMessage()], 401);
        }
    }
}
