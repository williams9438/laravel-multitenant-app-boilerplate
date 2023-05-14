<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
//Password Broker Facade
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    /**
     * This method overrides Shows form to request password reset
     * @return Void
    */
    public function showLinkRequestForm()
    {
        return view('tenant.auth.passwords.email');
    }

    // /**
    //  * Password Broker for Tenant Model
    //  * @return Response
    // */
    // public function broker()
    // {
    //     // return Password::broker('tenants');
    //     return Password::broker(Tenant::getTableName());
    // }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        $user = Tenant::where('email', $request->email)->first();
    
        if (isset($user) && $user->status == Tenant::DISABLED) {
            return back()->with('message', 'This Tenant is not activated or is disabled. Contact administrator for assitance to enable This Tenants.');
        } else {
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );

            if ($response === Password::RESET_LINK_SENT) {
                return back()->with('status', trans($response));
            }

            return back()->withErrors(
                ['email' => trans($response)]
            );
        }
    }
}
