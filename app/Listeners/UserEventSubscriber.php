<?php

namespace App\Listeners;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserEventSubscriber
{
    /**
     * Handle user login events
     */
    public function handleUserLogin($event)
    {
        // Regenerate API token
        $event->user->api_token = Str::random(32);
        $event->user->save();

        // Activity
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.auth.login');
        $activity->save();
    }

    /**
     * Handle user logout events
     */
    public function handleUserLogout($event)
    {
        // Revoke the API token
        $event->user->api_token = null;
        $event->user->save();

        // Activity
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.auth.logout');
        $activity->save();
    }

    /**
     * Register the listeners for the subscriber
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