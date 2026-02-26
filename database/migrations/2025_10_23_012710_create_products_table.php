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
    Schema::create('produks', function (Blueprint $table) { // ✅ ubah 'products' jadi 'produks'
        $table->id(); // <- ini auto increment integer (1,2,3,...)
        $table->string('nama');
        $table->integer('harga');
        $table->integer('stok')->default(0);
        $table->timestamps();
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
