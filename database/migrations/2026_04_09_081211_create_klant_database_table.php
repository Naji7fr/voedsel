<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table 1: Klant — personal info
        Schema::create('Klant', function (Blueprint $table) {
            $table->increments('klant_id');
            $table->string('voornaam', 100);
            $table->string('achternaam', 100);
            $table->string('telefoonnummer', 15)->unique();
            $table->string('email', 100)->unique();
            $table->integer('aantal_volwassenen')->default(0);
            $table->integer('aantal_kinderen')->default(0);
            $table->integer('aantal_babys')->default(0);
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable()->default(null);
        });

        // Table 2: KlantAdres — address info linked to Klant
        Schema::create('KlantAdres', function (Blueprint $table) {
            $table->increments('adres_id');
            $table->unsignedInteger('klant_id');
            $table->foreign('klant_id')->references('klant_id')->on('Klant')->onDelete('cascade');
            $table->string('straat', 150);
            $table->string('postcode', 10);
            $table->string('stad', 100);
            $table->string('opmerking', 255)->nullable();
            $table->timestamps();
        });

        // SQL VIEW met LEFT JOIN: klant + adresregels (meerdere rijen per klant bij meerdere adressen).
        // Leesbaar in SQLite: SELECT * FROM KlantOverzicht;
        DB::statement('
            CREATE VIEW IF NOT EXISTS KlantOverzicht AS
            SELECT
                k.klant_id,
                k.voornaam,
                k.achternaam,
                k.email,
                k.telefoonnummer,
                a.adres_id,
                a.straat,
                a.postcode,
                a.stad
            FROM Klant k
            LEFT JOIN KlantAdres a ON k.klant_id = a.klant_id
        ');
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS KlantOverzicht');

        Schema::dropIfExists('KlantAdres');
        Schema::dropIfExists('Klant');
    }
};
