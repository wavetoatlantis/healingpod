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
        Schema::create('riwayat_terapi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("pasien_id")->nullable()->constrained("pasiens");
            $table->string("kode_game")->nullable();
            $table->integer("waktu")->nullable();
            $table->integer("point")->nullable();
            $table->integer("jarak")->nullable();
            $table->boolean("is_done")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_terapi_details');
    }
};
