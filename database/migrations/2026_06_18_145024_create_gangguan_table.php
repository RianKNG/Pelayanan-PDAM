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
        Schema::create('gangguan', function (Blueprint $table) {
              $table->id();
            $table->string('kode_laporan')->unique();
            $table->enum('jenis_gangguan', ['transmisi', 'distribusi']);
            $table->enum('sumber_jalur', [
                'ipa', 'reservoir', 'sumur_bor', 'mata_air', 
                'sungai', 'jalur_utama', 'jalur_cabang', 'sambungan_rumah'
            ]);
            $table->enum('tipe_kerusakan', [
                'bocor', 'pecah', 'mampet', 'korosi',
                'rusak_ringan', 'rusak_berat',
                'valve_rusak', 'meter_rusak', 'lainnya'
            ]);
            $table->enum('ukuran_pipa', [
                '6 inch', '4 inch', '3 inch', '2 inch', 
                '1.25 inch', '1 inch', '0.5 inch'
            ]);
            $table->text('lokasi');
            $table->text('wilayah_terdampak');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('foto')->nullable();
            $table->string('pelapor');
            $table->string('no_hp_pelapor');
            $table->enum('status', ['menunggu', 'dalam_proses', 'selesai'])->default('menunggu');
            $table->text('deskripsi')->nullable();
            $table->text('catatan_perbaikan')->nullable();
            $table->date('tanggal_laporan');
            $table->date('estimasi_selesai')->nullable();
            $table->timestamp('selesai_diperbaiki')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gangguan');
    }
};
