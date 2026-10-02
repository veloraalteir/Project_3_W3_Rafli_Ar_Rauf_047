<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dateTime('start_at')->nullable()->after('activity_date');
            $table->dateTime('end_at')->nullable()->after('start_at');
            $table->string('location', 255)->nullable()->after('end_at');
            $table->unsignedInteger('capacity')->nullable()->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn([
                'start_at',
                'end_at',
                'location',
                'capacity',
            ]);
        });
    }
};