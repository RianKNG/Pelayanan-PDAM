<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Jalur Pipa (Line)
        Schema::create('jalur_pipa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jalur');
            $table->enum('jenis_jalur', ['transmisi', 'distribusi']);
            $table->enum('ukuran_pipa', ['6 inch', '4 inch', '3 inch', '2 inch', '1.25 inch', '1 inch']);
            $table->enum('warna', ['#ef4444', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#06b6d4']);
            $table->integer('ketebalan')->default(4);
            $table->json('coordinates'); // Array [lat, lng]
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel Bangunan/Area (Polygon)
        Schema::create('bangunan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bangunan');
            $table->enum('jenis_bangunan', [
                'reservoir', 'ipa', 'kantor', 'rumah_pompa',
                'gedung', 'sekolah', 'rumah_sakit', 'masjid',
                'pasar', 'lainnya'
            ]);
            $table->string('warna')->default('#3b82f6');
            $table->json('coordinates'); // Array polygon
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel Titik Penting (Marker)
        Schema::create('titik_penting', function (Blueprint $table) {
            $table->id();
            $table->string('nama_titik');
            $table->enum('jenis_titik', [
                'valve', 'hydrant', 'meter', 'sambungan',
                'pompa', 'tandon', 'lainnya'
            ]);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('titik_penting');
        Schema::dropIfExists('bangunan');
        Schema::dropIfExists('jalur_pipa');
    }
};