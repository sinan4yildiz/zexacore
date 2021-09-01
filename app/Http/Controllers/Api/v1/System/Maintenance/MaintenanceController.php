<?php

namespace App\Http\Controllers\Api\v1\System\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Maintenance\BackupResource;
use Illuminate\Support\Facades\Cache;

class MaintenanceController extends Controller
{
    /**
     * Clear cache
     *
     */
    public function clearCache()
    {
        Cache::flush();
    }
}
