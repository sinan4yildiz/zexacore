<?php

namespace App\Listeners;

use Illuminate\Support\Str;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function handleUserLogin($event)
    {
        // Regenerate API token
        $event->user->api_token = Str::random(32);
        $event->user->save();
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout($event)
    {
        // Empty API token
        $event->user->api_token = null;
        $event->user->save();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            [UserEventSubscriber::class, 'handleUserLogin']
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            [UserEventSubscriber::class, 'handleUserLogout']
        );
    }
}