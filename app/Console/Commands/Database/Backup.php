<?php

namespace App\Console\Commands\Database;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class Backup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup {--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Saves a database backup.';

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
        /**
         * File
         */
        $name = 'backup_' . Str::random(4) . '_' . ($this->option('name') ?? Carbon::now()->format('d-m-Y-H:i'));
        $path = storage_path('app/backup/' . Str::of($name)->slug()->finish('.sql'));


        /**
         * SQL command
         */
        $command = 'mysqldump --skip-comments' .
            ' --host=' . env('DB_HOST') .
            ' --port=' . env('DB_PORT') .
            ' --user=' . env('DB_USERNAME') .
            ' --password=' . env('DB_PASSWORD') . ' ' . env('DB_DATABASE') . ' > ' . $path;


        /**
         * Progress bar start
         */
        $bar = $this->output->createProgressBar(1);
        $bar->start();


        /**
         * Execute
         */
        $process = Process::fromShellCommandline($command);
        $process->run();


        /**
         * Delete the empty backup if failed
         */
        if (!$process->isSuccessful()) {
            File::delete($path);
        }


        /**
         * Progress bar finish
         */
        $bar->finish();


        /**
         * Output
         */
        $this->output->success('The backup file has been saved.');


        /**
         * Status
         */
        return $process->isSuccessful();
    }
}
