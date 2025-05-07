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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppdb_id');
            // $table->enum('jenis_pembayaran', ['SPP', 'Infaq', 'Seragam']);
            $table->string('jenis_pembayaran')->nullable();
            $table->decimal('nominal_spp', 12, 2)->nullable();
            $table->decimal('nominal_infaq', 12, 2)->nullable();
            $table->decimal('nominal_seragam', 12, 2)->nullable();
            $table->decimal('nominal_kolektif', 12, 2)->nullable();
            $table->date('tgl_bayar');
            $table->enum('status', ['Lunas', 'Belum Lunas'])->default('Belum Lunas');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Foreign key constraint
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
        Schema::dropIfExists('pembayarans');
    }
};
