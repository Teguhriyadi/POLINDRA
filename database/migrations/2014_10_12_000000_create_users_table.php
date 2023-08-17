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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('nama', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->string("created_by", 50)->nullable();
            $table->string("foto")->nullable();
            $table->enum("role", ["admin", "wadir", "ormawa"]);
            $table->enum("status", [1, 0])->default(0);
            $table->text("deskripsi")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
