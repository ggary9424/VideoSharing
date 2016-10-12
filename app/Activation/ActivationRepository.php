<?php

namespace App\Activation;

use Carbon\Carbon;
use Illuminate\Database\Connection;
use App\Models\User;
use App\Models\UserActivation;

class ActivationRepository
{
    protected function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    public function createActivation(User $user)
    {
        $activation = $this->getActivationByUser($user);

        if (!$activation) {
            return $this->createToken($user);
        }
        return $this->regenerateToken($user);
    }

    private function regenerateToken(User $user)
    {
        $token = $this->getToken();
        UserActivation::update([
            'token' => $token
        ]);
        return $token;
    }

    private function createToken(User $user)
    {
        $token = $this->getToken();
        UserActivation::create([
            'user_id' => $user->id,
            'token' => $token                      
        ]);
        return $token;
    }

    public function getActivationByUser(User $user)
    {
        return UserActivation::where('user_id', $user->id)
                            -> first();
    }


    public function getActivationByToken(String $token)
    {
        return UserActivation::where('token', $token)->first();
    }

    public function deleteActivation(String $token)
    {
        return UserActivation::where('token', $token)->delete();
    }

}
