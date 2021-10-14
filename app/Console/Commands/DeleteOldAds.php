<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ad;

class DeleteOldAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteOldAds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete ads older than 30 days.';

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
        $result = Ad::where('type', 'free')
                    ->where('created_at', '<', date('Y-m-d H:i:s', time() - (30 * 24 * 60 * 60)))
                    ->delete();

        if ($result) {
            $this->info('The command completed successfully!');
        } else {
            $this->info('There was an error while running the command. Please try again later. If the error persists, please contact us.');
        }
    }
}
