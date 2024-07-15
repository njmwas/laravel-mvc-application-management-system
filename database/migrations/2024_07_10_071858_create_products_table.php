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
            $table->string('slug')->unique('slug');
            $table->foreignId('category_id')->constrained()->noActionOnDelete();
            $table->float('price')->default(0);
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('si_unit', 5)->nullable();
            $table->integer('total_in_stock')->default(0);
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
