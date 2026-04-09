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
        Schema::create('Klant', function (Blueprint $table) {
            // Primary key
            $table->increments('klant_id');

            // Klant basisgegevens
            $table->string('gezinsnaam', 100);
            $table->string('adres', 150);
            $table->string('postcode', 10);
            $table->string('telefoonnummer', 15);
            $table->string('email', 100)->unique();

            // Gezinssamenstelling
            $table->integer('aantal_volwassenen');
            $table->integer('aantal_kinderen');
            $table->integer('aantal_babys');

            // Systeemvelden
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Klant');
    }
};
