<?php

namespace Coderflex\LaravelTicket\Database\Factories;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        $tableName = config('laravel_ticket.table_names.messages', 'messages');

        Schema::create($tableName['table'], function (Blueprint $table) use ($tableName) {
            $table->id();
            $table->foreignId($tableName['columns']['user_foreign_id']);
            $table->foreignId($tableName['columns']['ticket_foreign_id']);
            $table->text('message');
            $table->dateTime('is_read')->default(null)->nullable();
            $table->timestamps();
        });
    }
};
