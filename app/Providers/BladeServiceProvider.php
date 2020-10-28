<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use App\Helpers\SVG;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('svg', function ($filename) {
            return "<?php echo SVG::file(Str::of($filename)->trim(\"'\")); ?>";
        });

        Blade::directive('icon', function ($filename) {
            return "<?php echo SVG::icon(Str::of($filename)->trim(\"'\")); ?>";
        });

        Blade::directive('flag', function ($filename) {
            return "<?php echo SVG::flag(Str::of($filename)->trim(\"'\")); ?>";
        });

    }
}
