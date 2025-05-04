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
        Schema::create('dokumen_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppdb_id');
            $table->string('kk')->nullable();
            $table->string('akte')->nullable();
            $table->string('surat_keterangan_lulus')->nullable();
            $table->string('kip')->nullable();
            $table->timestamps();
            $table->foreign('ppdb_id')
                ->references('id')
                ->on('ppdbs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_siswas');
    }
};
