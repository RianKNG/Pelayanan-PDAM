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
    Schema::table('gangguan_fotos', function (Blueprint $table) {
        // Menambahkan kolom urutan jika belum ada
        $table->integer('urutan')->default(0)->after('foto_path');
    });
}

public function down(): void
{
    Schema::table('gangguan_fotos', function (Blueprint $table) {
        $table->dropColumn('urutan');
    });
}
};
