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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('price', 15, 8);
            $table->text('description');
            $table->foreignId('user_id')->constrained('users')->CascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->CascadeOnDelete();
            $table->boolean('is_approved')->default(false);
             $table->boolean('is_sold')->default(false);
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
