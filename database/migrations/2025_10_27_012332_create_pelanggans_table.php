<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
          Schema::create('pelanggans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pelanggan');
        $table->string('alamat')->nullable();
        $table->string('nomor_telepon')->nullable();
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->dropForeign(['pelanggan_id']);
            $table->dropColumn('pelanggan_id');
        });
    }
};
