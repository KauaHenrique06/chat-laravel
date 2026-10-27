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
        Schema::create('chat_group_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->text('body');
            $table->uuid('chat_group_id');
            $table->uuid('user_id');

            $table->foreign('chat_group_id')->references('id')->on('chat_groups')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_group_messages');
    }
};
