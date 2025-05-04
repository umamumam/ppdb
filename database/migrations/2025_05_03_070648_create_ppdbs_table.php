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
        Schema::create('ppdbs', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nik_siswa')->nullable();
            $table->string('nama_siswa');
            $table->string('foto')->nullable();
            $table->enum('jeniskelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('kelas')->nullable();
            $table->enum('program', ['Keagamaan', 'MIPA', 'IPS'])->nullable();
            $table->integer('anak_ke')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->enum('pendidikan_ayah', ['SD/MI', 'SMP/MTS', 'SMA/MA', 'D3', 'S1', 'S2', 'S3'])->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->enum('pendidikan_ibu', ['SD/MI', 'SMP/MTS', 'SMA/MA', 'D3', 'S1', 'S2', 'S3'])->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('hp_siswa')->nullable();
            $table->string('hp_ortu')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('npsn')->nullable();
            $table->string('nsm')->nullable();
            $table->string('alamat_sekolah')->nullable();
            $table->string('no_kip')->nullable();
            $table->string('no_kks')->nullable();
            $table->string('no_pkh')->nullable();
            $table->enum('jenis_pendaftar', ['baru', 'alumni'])->default('baru');
            $table->string('no_pendaftaran')->unique();
            $table->foreignId('tahun_pelajaran_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdbs');
    }
};
