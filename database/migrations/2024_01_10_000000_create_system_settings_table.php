<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('type')->default('text'); // text, html, json, etc.
            $table->string('group')->default('general'); // general, legal, about, etc.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_settings');
    }
};