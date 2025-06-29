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
        Schema::create('user_privacy_settings', function (Blueprint $table) {
            $table->id();
                $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('followers_visibility', ['everyone', 'only_me'])->default('everyone');
            $table->enum('profile_visibility', ['everyone', 'followers'])->default('everyone');
            $table->enum('comment_permission', ['everyone', 'followers'])->default('everyone');
            $table->enum('reaction_visibility', ['everyone', 'followers'])->default('everyone');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('user_privacy_settings');
    }
};
