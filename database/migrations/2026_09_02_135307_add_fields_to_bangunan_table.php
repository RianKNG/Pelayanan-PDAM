<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('bangunan', function (Blueprint $table) {
        $table->string('ukuran_bangunan')->nullable()->after('jenis_bangunan');
        $table->decimal('elevasi', 10, 2)->nullable()->after('ukuran_bangunan');
        $table->string('sumber_elevasi')->nullable()->after('elevasi');
    });
}

public function down()
{
    Schema::table('bangunan', function (Blueprint $table) {
        $table->dropColumn(['ukuran_bangunan', 'elevasi', 'sumber_elevasi']);
    });
}
};
