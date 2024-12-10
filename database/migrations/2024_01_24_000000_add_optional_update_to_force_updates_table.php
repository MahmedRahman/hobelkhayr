<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOptionalUpdateToForceUpdatesTable extends Migration
{
    public function up()
    {
        Schema::table('force_updates', function (Blueprint $table) {
            $table->boolean('is_optional_update')->default(false)->after('is_force_update');
            $table->text('update_description')->nullable()->after('is_optional_update');
        });
    }

    public function down()
    {
        Schema::table('force_updates', function (Blueprint $table) {
            $table->dropColumn(['is_optional_update', 'update_description']);
        });
    }
}
