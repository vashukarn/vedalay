<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Utilities\LogActivity;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\AppSetting;
use Illuminate\Contracts\Session\Session;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(fn () => view('admin.auth.login'));

        Fortify::authenticateThrough(function (Request $request) {
            LogActivity::addToLog('Login Attempt-'. 'Email: '. $request->email);
            $user = User::where('email', $request->email)
            // ->orWhere('mobile',$request->email)
            // ->where('status',true)
            // ->whereIn('type',['admin', 'superadmin', 'staff'])
            ->first();
            return array_filter([
                config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                (@$user->two_factor_secret)?RedirectIfTwoFactorAuthenticatable::class:'',
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ]);
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)
            // ->orWhere('mobile',$request->email)
            // ->where('status',true)
            // ->whereIn('type',['admin', 'superadmin', 'staff'])
            ->first();
            if ($user && Hash::check($request->password, $user->password)) {
                if($user->two_factor_secret){
                    LogActivity::addToLog('युजर लगइन भएको: '.$request->email,$user->id);
                }else{
                    LogActivity::addToLog('युजर लगइन भएको: '.$request->email,$user->id);
                }
                $request->session()->flash('success',"You are Logged in successfully");
           
                // dd($appsetting->website_content_item);
              
                return $user;
            }
        });

        Fortify::confirmPasswordView(fn() => view('admin.auth.password-confirm'));
        Fortify::requestPasswordResetLinkView(fn () =>view('admin.auth.forgot-password'));
        Fortify::resetPasswordView(fn ($request) =>view('admin.auth.reset-password', ['request' => $request]));
        Fortify::verifyEmailView(fn () =>view('admin.auth.verify-email'));
        Fortify::twoFactorChallengeView(fn() =>view('admin.auth.two-factor-challenge'));
    }
}
