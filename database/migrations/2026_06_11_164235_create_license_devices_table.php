<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('license_devices')) {
            Schema::create('license_devices', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('license_id');
                $table->string('device_fingerprint');
                $table->string('processor_id')->nullable();
                $table->string('device_name')->nullable();
                $table->string('machine_user')->nullable();
                $table->string('os')->nullable();
                $table->string('app_version')->nullable();
                $table->string('ip_address')->nullable();

                $table->enum('status', [
                    'pending',
                    'approved',
                    'rejected',
                    'blocked',
                ])->default('pending');

                $table->timestamp('requested_at')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->timestamp('rejected_at')->nullable();
                $table->timestamp('blocked_at')->nullable();
                $table->timestamp('last_seen_at')->nullable();

                $table->unsignedBigInteger('approved_by')->nullable();
                $table->text('note')->nullable();

                $table->timestamps();

                $table->unique(['license_id', 'device_fingerprint']);
                $table->index(['license_id', 'status']);

                $table->foreign('license_id')
                    ->references('id')
                    ->on('licenses')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('license_devices');
    }
};