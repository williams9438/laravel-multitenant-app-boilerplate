<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\Auth\LoginController;
use App\Http\Controllers\Tenant\Auth\RegisterController; 
use App\Http\Controllers\Tenant\Auth\ForgotPasswordController;
use App\Http\Controllers\Tenant\Auth\ResetPasswordController;


/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', function () {
        // dd(\App\Models\User::all());
        // return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
        $tenant_id = tenant('id');
        return view('tenant.welcome', compact('tenant_id'));
    })->name('tenant.show_welcome');

    Route::get('/home', function () {
        $tenant_id = tenant('id');
        return view('tenant.home', compact('tenant_id'));
    })->name('tenant.show_home');

    /*
        Route for All Tenant Authentication
    */
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('tenant.show_login_form');
    Route::post('login', [LoginController::class, 'login'])->name('tenant.login');

    Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('tenant.show_register_form');
    Route::post('register', [RegisterController::class, 'register'])->name('tenant.register');

    Route::post('logout', [LoginController::class, 'logout'])->name('tenant.logout');

    //Password reset routes
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('tenant.show_forget_pass_form');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('tenant.forget_pass');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('tenant.show_reset_pass_form');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('tenant.reset_pass');
    
});


/*
Tenants API Endpoints
*/

Route::middleware([
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('api')->group(function () {

    Route::get('/users', function () {
        return json_encode(\App\Models\User::all());
    });
    
});
