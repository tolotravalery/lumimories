<?php


namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmailsOther;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AuthController extends BaseController
{
    use SendsPasswordResetEmailsOther;

    public function passWordResetFront()
    {
        $this->seo("Lumimories - PassWord reset", "PassWord reset Lumimories", "Se connecter, Lumimories", "");
        return view('password-reset-email');
    }

    public function sendResetLinkEmailFront(Request $request)
    {
        $this->sendResetLinkEmail($request);
        return redirect(url('/password-reset-front'));
    }

    public function showResetFormFront(Request $request, $token = null)
    {
        $this->seo("Lumimories - PassWord reset", "PassWord reset Lumimories", "Se connecter, Lumimories", "");
        return view('password-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

}
