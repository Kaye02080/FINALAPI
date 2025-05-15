<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('send_money', function (Blueprint $table) {
            $table->unsignedBigInteger('sender_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('send_money', function (Blueprint $table) {
            $table->unsignedBigInteger('sender_id')->nullable(false)->change();
        });
    }
};

