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
        Schema::create('chat_group_message_read', function (Blueprint $table) {
            
            $table->uuid('chat_group_message_id');
            $table->uuid('user_id');

            $table->foreign('chat_group_message_id')->references('id')->on('chat_group_messages')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->primary(['user_id', 'chat_group_message_id']);

            $table->timestampTz('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_group_message_read');
    }
};
