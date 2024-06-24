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
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete;
            $table->string('name');
            $table->double('price');
            $table->text('description');
            $table->date('expiration_date')->nullable();
            $table->text('image_url')->nullable();
            $table->integer('quantity')->default(1);
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete;
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
