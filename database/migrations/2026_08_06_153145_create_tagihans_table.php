<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->string('no_sambungan')->index();
            $table->string('no_rekening');
            $table->string('nama_pelanggan');
            $table->string('alamat');
            $table->string('kode_gol')->index();
            $table->integer('stand_awal')->default(0);
            $table->integer('stand_akhir')->default(0);
            $table->integer('pakai')->default(0);
            $table->decimal('harga_air', 15, 2)->default(0);
            $table->decimal('beban_tetap', 15, 2)->default(0);
            $table->decimal('materai', 15, 2)->default(0);
            $table->decimal('total_rekening', 15, 2)->default(0);
            $table->string('bulan');
            $table->string('tahun');
            $table->timestamps();
            
            $table->index(['bulan', 'tahun']);
            $table->index(['no_sambungan', 'bulan', 'tahun']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihans');
    }
};