<?php
// database/migrations/xxxx_xx_xx_create_zona_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zona', function (Blueprint $table) {
            $table->id();
            $table->string('nama_zona');
            $table->string('jenis_zona'); // Zona 1, Zona 2, DAS, dll
            $table->string('warna', 20);
            $table->decimal('elevasi_min', 8, 2)->nullable();
            $table->decimal('elevasi_max', 8, 2)->nullable();
            $table->json('coordinates');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zona');
    }
};