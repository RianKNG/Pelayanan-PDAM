<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('golongan_histories', function (Blueprint $table) {
            $table->id();
            $table->string('no_sambungan')->index();
            $table->string('golongan_lama')->nullable();
            $table->string('golongan_baru');
            $table->date('tanggal_perubahan');
            $table->string('alasan_perubahan')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('bulan');
            $table->string('tahun');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('golongan_histories');
    }
};