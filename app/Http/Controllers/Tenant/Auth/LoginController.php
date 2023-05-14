<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Shows seller login form.
     *
     * @return void
     */
    public function showLoginForm()
    {
        return view('tenant.auth.login');
    }

    /**
     * This method overrides $redirectTo property variable by creating a authenticated() method here to overide the $redirectTo property variables
     * provided above which is the default behaviour of laravel after login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  var  $user
     * @return \Illuminate\Http\Response
    */
    protected function authenticated(Request $request, $user)
    {
        if ($user->status == Tenant::USER_DISABLED) {

            $message = 'This account is not activated or is disabled. Contact administrator for assitance to enable the account';

            // Log the user out.
            $this->logout($request);

            // Return them to the log in form.
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    // This is where we are providing the error message.
                    $this->username() => $message,
                ]);
        }
    }

    /**
     * Log the Tenant out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('tenant.show_welcome');
    }
}
