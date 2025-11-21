<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');              
            $table->text('notes')->nullable();
            $table->boolean('is_lifetime')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->string('serial')->unique();        
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('licenses');
    }
}
