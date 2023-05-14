<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

//Auth Facade
use Illuminate\Support\Facades\Auth;
//Password Broker Facade
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Models\Tenant;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;

    public function __construct()
    {
      $this->middleware('company_user_guest')->except('logout');
      $this->redirectTo = Request()->segment(1) .'/dashboard';
    }

    /**
     * Show form to Tenant user where they can reset password
     * @return Response
    */
    public function showResetForm(Request $request, $token = null)
    {
        return view('tenant.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
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

    /**
     * returns authentication guard of company users
     * @return Response
    */
    protected function guard()
    {
        return Auth::guard('tenant');
    }
}
