<?php

namespace App\Listeners;

use App\Mail\welcomeMail;
use App\Setting\SettingSystem;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        try {
            Mail::to($event->user->email)->queue(
                new welcomeMail(
                    'به '.env('APP_NAME', 'حق لیبل').' خوش آمدید',
                    str_replace('$name',$event->user->name,SettingSystem::get('welcome_message'))
                )
            );
        } catch (\Exception $e){
        }
    }
}
