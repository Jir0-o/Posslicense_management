<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('licenses') && !Schema::hasColumn('licenses', 'max_devices')) {
            Schema::table('licenses', function (Blueprint $table) {
                $table->unsignedInteger('max_devices')->default(1)->after('expires_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('licenses') && Schema::hasColumn('licenses', 'max_devices')) {
            Schema::table('licenses', function (Blueprint $table) {
                $table->dropColumn('max_devices');
            });
        }
    }
};