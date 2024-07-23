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
        Schema::create('scheduled_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('link')->nullable();
            $table->integer('duration')->nullable();
            $table->datetime('start_time')->nullable();
            $table->datetime('finish_time')->nullable();
            $table->foreignId('assigned_to')->nullable();
            $table->foreignId('assigned_from')->nullable();
            $table->string('status')->default('pending'); 
            $table->foreignId('rejected_by')->nullable();
            $table->text('rejected_reason')->nullable();
            $table->string('references')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_calls');
    }
};
