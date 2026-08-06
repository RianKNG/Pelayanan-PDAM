<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('titik_penting', function (Blueprint $table) {
            // Gunakan ENUM agar data yang masuk di DB sudah terpatok sesuai daftar ukuran
            $table->enum('ukuran', [
                '12 inch', '10 inch', '8 inch', '6 inch', 
                '4 inch', '3 inch', '2 inch', '1.5 inch', '1 inch'
            ])->nullable()->after('elevasi');
        });
    }

    public function down(): void
    {
        Schema::table('titik_penting', function (Blueprint $table) {
            $table->dropColumn('ukuran');
        });
    }
};