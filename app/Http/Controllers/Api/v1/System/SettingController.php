<?php

namespace App\Http\Controllers\Api\v1\System;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Http\Requests\Api\System\SettingRequest;
use App\Http\Resources\Api\System\SettingResource;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * All settings
     *
     */
    public function index()
    {
        /**
         * Query
         */
        $settings = Setting::all();

        /**
         * Response structure
         */
        return $settings->pluck('value', 'key');
    }

    /**
     * Update settings
     *
     * @param  \App\Http\Requests\Api\System\SettingRequest  $request
     * @param $id
     *
     */
    public function update(SettingRequest $request)
    {
        /**
         * Save the settings data
         */
        collect($request->post())->each(function ($value, $key) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        });


        /**
         * Forget the cache
         */
        Cache::forget('settings');


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.setting.update');
        $activity->save();

        return $this->index();
    }
}
