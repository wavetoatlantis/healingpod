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
        Schema::create('riwayat_terapis', function (Blueprint $table) {
            $table->id();
            $table->foreignId("terapi_id")->nullable()->constrained("terapis");
            $table->date("tgl_terapi")->nullable();
            $table->foreignId("pasien_id")->nullable()->constrained("pasiens");
            $table->foreignId("game_id")->nullable()->constrained("games");
            $table->integer("lama_terapi")->nullable();
            $table->integer("point")->nullable();
            $table->integer("jarak")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_terapis');
    }
};
