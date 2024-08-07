<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class ClearLogs extends Command
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
    protected $description = 'Clear log files';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Path to log files
        $logPath = storage_path('logs');

        // Get all log files in the log directory
        $files = File::glob($logPath . '/*.log');

        foreach ($files as $file) {
            File::delete($file);
        }

        $this->info('Log files have been cleared.');
    }
}
