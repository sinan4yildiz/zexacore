<?php

namespace App\Http\Controllers\Api\v1\System\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\System\Maintenance\BackupRequest;
use App\Http\Resources\Api\System\Maintenance\BackupResource;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class BackupController extends Controller
{
    /**
     * Backups
     *
     */
    public function index()
    {
        /**
         * Get the backups
         */
        $backups = collect(File::glob(storage_path('app/backup/*.sql')));


        /**
         * Format the data
         */
        $backups->each(function ($item, $key) use ($backups) {
            $backups->put($key, (object) [
                'name'       => basename($item),
                'created_at' => File::lastModified($item)
            ]);
        });


        /**
         * Response structure
         */
        return BackupResource::collection($backups->sortByDesc('created_at')->paginate(5));
    }

    /**
     * Create new backup
     *
     */
    public function create()
    {
        $exec = Artisan::call('database:backup', ['--name' => request('name')]);

        if (!$exec) {
            return Response::json(false, 500);
        }
    }

    /**
     * Restore backup
     *
     */
    public function restore($name)
    {
        $exec = Artisan::call('database:restore', ['name' => $name]);

        if (!$exec) {
            return Response::json(false, 422);
        }
    }

    /**
     * Rmove
     *
     */
    public function remove($name)
    {
        $file = storage_path('app/backup/' . $name);

        if (File::exists($file)) {
            File::delete($file);
        }
    }
}
