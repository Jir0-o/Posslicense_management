<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\License;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Notifications\LicenseExpiringNotification; 

class CheckLicensesExpiry extends Command
{
    protected $signature = 'licenses:check';
    protected $description = 'Check licenses and mark/send notifications for expiring licenses';

    public function handle()
    {
        $now = Carbon::now();

        $soon = $now->copy()->addDays(3);
        $licenses = License::where('is_lifetime', false)
            ->whereBetween('expires_at', [$now, $soon])
            ->get();

        foreach ($licenses as $lic) {

            Log::info("License expiring soon: id={$lic->id}, expires_at={$lic->expires_at}");
        }

        $this->info('License check finished. Found: ' . $licenses->count());
        return 0;
    }
}
