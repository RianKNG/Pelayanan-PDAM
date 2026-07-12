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
    Schema::create('gangguan_fotos', function (Blueprint $table) {
        $table->unsignedBigInteger('gangguan_id');
$table->foreign('gangguan_id')->references('id')->on('gangguan')->onDelete('cascade');
        $table->string('foto_path');
        $table->integer('foto_order')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gangguan_fotos');
    }
};
