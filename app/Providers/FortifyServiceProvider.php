<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // La limite de la connexion de l'authentification
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(3)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        //Pour retourner nos pages
        fortify::loginView(function(){
            return view('auth.login');
        });

        fortify::registerView(function(){
            return view('auth.register');
        });

        fortify::authenticateUsing(function(Request $request){
            $user = User::where('email', $request->email)->first();

            if($user && \Hash::check($request->password,$user->password)){
                if($user->is_deactivated){
                    throw ValidationException::withMessages(['email' => "Votre compte est désactivé. Vérifier votre adresse email et cliqué sur le lien d'annulation"]);
                }
                return $user;
            }
            return null;
        });
    }
}
