<?php

namespace App\Console\Commands\Logs;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Clear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the log file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        File::delete(storage_path('logs/laravel.log'));

        $this->output->success('The log file has been cleared.');
    }
}
