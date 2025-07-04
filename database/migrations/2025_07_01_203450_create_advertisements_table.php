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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->text('description');
            $table->date('publishing_end');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
