<?php

namespace App\Http\Controllers\Api\v1\System\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Maintenance\BackupResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogController extends Controller
{
    /**
     * Logs
     *
     */
    public function index()
    {
        $path = storage_path('logs/laravel.log');

        if (!File::exists($path)) {
            return trans('api/common.logs.empty');
        }

        $size = File::size($path);

        if ($size < 1024 * 1024 * 1.5) {
            return nl2br(File::get($path));
        } else {
            return trans('api/common.logs.too_big');
        }
    }

    /**
     * Write log
     *
     */
    public function write()
    {
        Log::error(Request::input('log'));
    }
}
