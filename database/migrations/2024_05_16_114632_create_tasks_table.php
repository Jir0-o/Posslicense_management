<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->enum('status', ['pending', 'completed', 'in_progress','incomplete'])->default('pending'); 
            $table->date('submit_date');
            $table->datetime('submit_by_date')->nullable();
            $table->text('message')->nullable();
            $table->text('admin_message')->nullable();
            $table->text('work_status')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('title_name_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            
            $table->foreign('title_name_id')
            ->references('id')
            ->on('title_names')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
