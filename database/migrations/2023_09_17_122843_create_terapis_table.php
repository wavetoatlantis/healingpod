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
        Schema::create('terapis', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->nullable()->constrained("companies");
            $table->foreignId("pasien_id")->nullable()->constrained("pasiens");
            $table->date("tgl_terapi")->nullable();
            $table->text("keterangan_sebelum_terapi")->nullable();
            $table->text("keterangan_setelah_terapi")->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terapis');
    }
};
