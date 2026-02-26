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
        Schema::table('produks', function (Blueprint $table) {
            // Check if the 'stok' column already exists before adding it
            if (!Schema::hasColumn('produks', 'stok')) {
                $table->integer('stok')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn('stok');
        });
    }
    
};
