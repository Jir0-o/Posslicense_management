<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LogOutUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:logout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log out all users by clearing session data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Clear the session table to log out users
        DB::table('sessions')->truncate();

        $this->info('All users have been logged out.');
        return Command::SUCCESS;
    }
}
