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
        Schema::table('reels', function (Blueprint $table) {
            $table->string('thumbnail_path')->nullable();
        });
    }


    public function down(): void
    {
        Schema::table('reels', function (Blueprint $table) {
            //
        });
    }
};
