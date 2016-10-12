<?php

namespace App\Activation;

use App\Models\User;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class ActivationService
{
    protected $mailer;

    protected $activationRepo;

    protected $resendAfter = 24;

    public function __construct(Mailer $mailer, ActivationRepository $activationRepo)
    {
        $this->mailer = $mailer;
        $this->activationRepo = $activationRepo;
    }

    public function sendActivationMail(User $user)
    {
        if ($user->activated || !$this->shouldSend($user)) {
            return;
        }
        /* should send activation mail to user */
        $token = $this->activationRepo->createActivation($user);
        $link = route('user.activate', $token);
        $this->mailer->send('auth.emails.activation_link', ['link'=>$link], 
                                function (Message $m) use ($user) {
            $m->from('videosharing@videosharing.com', 'Videosharing Laravel');
            $m->to($user->email, $user->name)->subject('Activation mail');
        });
    }

    public function activateUser(String $token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);
        /* if true, it means database does not have this token */
        if ($activation === null) {
            return null;
        }
        $activation->user->activated = true;
        $activation->user->save();
        $this->activationRepo->deleteActivation($token);
        return $activation->user;
    }

    private function shouldSend(User $user)
    {
        $activation = $this->activationRepo->getActivationByUser($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }

}