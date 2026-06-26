<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('debit_kebocoran', function (Blueprint $table) {
            $table->id();
            $table->string('ukuran_pipa', 50); // 3 inch, 6 inch, dll
            $table->string('tipe_kerusakan', 100); // bocor, pecah, mampet, dll
            $table->decimal('debit_bocor', 10, 2); // dalam m³/jam
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
        
        // Insert data awal
        DB::table('debit_kebocoran')->insert([
            ['ukuran_pipa' => '3 inch', 'tipe_kerusakan' => 'bocor', 'debit_bocor' => 2, 'keterangan' => 'Rembesan / Bocor Kecil'],
            ['ukuran_pipa' => '3 inch', 'tipe_kerusakan' => 'pecah', 'debit_bocor' => 15, 'keterangan' => 'Pipa Retak / Bocor Sedang'],
            ['ukuran_pipa' => '3 inch', 'tipe_kerusakan' => 'rusak_berat', 'debit_bocor' => 25, 'keterangan' => 'Pipa Pecah Total / Semburan'],
            ['ukuran_pipa' => '6 inch', 'tipe_kerusakan' => 'bocor', 'debit_bocor' => 5, 'keterangan' => 'Rembesan / Bocor Kecil'],
            ['ukuran_pipa' => '6 inch', 'tipe_kerusakan' => 'pecah', 'debit_bocor' => 40, 'keterangan' => 'Pipa Retak / Bocor Sedang'],
            ['ukuran_pipa' => '6 inch', 'tipe_kerusakan' => 'rusak_berat', 'debit_bocor' => 98, 'keterangan' => 'Pipa Pecah Total / Semburan'],
            ['ukuran_pipa' => '4 inch', 'tipe_kerusakan' => 'bocor', 'debit_bocor' => 3, 'keterangan' => 'Rembesan / Bocor Kecil'],
            ['ukuran_pipa' => '4 inch', 'tipe_kerusakan' => 'pecah', 'debit_bocor' => 25, 'keterangan' => 'Pipa Retak / Bocor Sedang'],
            ['ukuran_pipa' => '4 inch', 'tipe_kerusakan' => 'rusak_berat', 'debit_bocor' => 50, 'keterangan' => 'Pipa Pecah Total / Semburan'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('debit_kebocoran');
    }
};