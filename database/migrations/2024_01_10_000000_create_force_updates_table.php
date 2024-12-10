<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForceUpdatesTable extends Migration
{
    public function up()
    {
        Schema::create('force_updates', function (Blueprint $table) {
            $table->id();
            $table->string('version_number');
            $table->enum('platform', ['android', 'ios']);
            $table->boolean('is_force_update')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('force_updates');
    }
}
