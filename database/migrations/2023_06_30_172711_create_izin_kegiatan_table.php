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
        Schema::create('izin_kegiatan', function (Blueprint $table) {
            $table->string("id", 50)->primary();
            $table->string("user_id", 50);
            $table->string("nama_kegiatan", 100);
            $table->string("file_laporan");
            $table->string("tempat_pelaksanaan", 100);
            $table->datetime("mulai");
            $table->datetime("akhir");
            $table->enum("status", [0, 1, 2, 3])->default(0);
            $table->text("komentar")->nullable();
            $table->string("file_surat_balasan")->nullable();
            $table->string("user_validasi_id", 100)->nullable();
            $table->tinyInteger("is_validasi")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_kegiatan');
    }
};
