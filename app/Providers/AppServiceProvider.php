<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
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
        //
        Paginator::useBootstrap();
        VerifyEmail::$toMailCallback=function( $notifiable, $verificationUrl){
            return (new MailMessage)
            ->subject(Lang::get('Verify Email Address'))
            ->greeting('Hola '. $notifiable->name)
            ->line('Tu cuenta en Fichadas ha sido creada con éxito y se te asignó la contraseña: '.session('pwdNE'). ' , te aconsejamos que la cambies.')
            ->line('Te dejamos el siguiente enlace para que verifiques tu correo electrónico.')
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(Lang::get('Verify Email Address'), $verificationUrl)
            ->line(Lang::get('If you did not create an account, no further action is required.'));

            session()->forget('pwdNE');
        };

    }
}
