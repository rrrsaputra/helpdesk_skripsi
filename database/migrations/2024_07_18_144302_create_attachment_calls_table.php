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
        Schema::create('attachment_calls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scheduled_call_id');
            $table->string('name');
            $table->foreign('scheduled_call_id')->references('id')->on('scheduled_calls')->onDelete('cascade');
            $table->string('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_calls');
    }
};
