<?php

namespace App\Services;

use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Factory;

class FirebaseService
{
    protected Auth $auth;

    public function __construct()
    {
        $this->auth = (new Factory)
            ->withServiceAccount(config('firebase.projects.app.credentials'))
            ->createAuth();
    }

    public function verifyIdToken(string $idToken): ?array
    {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);

            return $verifiedIdToken->claims()->all();
        } catch (FirebaseException $e) {
            return null;
        }
    }

    public function getUser(string $uid)
    {
        try {
            return $this->auth->getUser($uid);
        } catch (FirebaseException $e) {
            return null;
        }
    }
}
