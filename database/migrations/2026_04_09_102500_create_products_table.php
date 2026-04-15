<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table 1: products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('name');
            $table->string('category');
            $table->integer('stock')->default(0);
            $table->boolean('is_used_in_food_package')->default(false);
            $table->timestamps();
        });

        // Table 2: product_leveranciers — suppliers linked to products
        Schema::create('product_leveranciers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('naam', 150);
            $table->string('contactpersoon', 100)->nullable();
            $table->string('telefoonnummer', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('opmerking', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_leveranciers');
        Schema::dropIfExists('products');
    }
};
