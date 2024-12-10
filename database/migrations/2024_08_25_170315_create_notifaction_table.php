<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifactions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->json('user_ids')->nullable(); // Array of user IDs for multiple users
            $table->boolean('send_to_all')->default(false); // Flag for sending to all users
            $table->json('data')->nullable(); // Additional data in JSON format
            $table->enum('status', ['sent', 'pending', 'failed'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifactions');
    }
};