<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Process\Process;

class Restore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:restore {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restores a database backup.';

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
         * Backup file
         */
        $backup = storage_path('app/backup/' . $this->argument('name'));


        /**
         * Check the backup file
         */
        if (!File::exists($backup)) {
            $this->output->error('The backup file does not exist.');
            return false;
        }


        /**
         * SQL command
         */
        $command = 'mysql' .
            ' --host=' . env('DB_HOST') .
            ' --port=' . env('DB_PORT') .
            ' --user=' . env('DB_USERNAME') .
            ' --password="' . env('DB_PASSWORD') . '" ' . env('DB_DATABASE') . ' < ' . $backup;


        /**
         * Progress bar start
         */
        $this->output->newLine();
        $bar = $this->output->createProgressBar(1);
        $bar->start();


        /**
         * Execute
         */
        $process = Process::fromShellCommandline($command);
        $process->run();


        /**
         * Progress bar finish
         */
        $bar->finish();
        $this->output->newLine(2);


        /**
         * Status
         */
        if ($process->isSuccessful()) {
            $this->output->success('The database has been restored.');

            return true;
        } else {
            $this->output->error('Command failed. Please make sure shell access is enabled.');

            return false;
        }
    }
}
