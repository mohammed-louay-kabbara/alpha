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
        Schema::create('password_resets_custom', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('otp_code'); // كود من 4 خانات
            $table->timestamp('expires_at'); // وقت الانتهاء
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_resets_custom');
    }
};
