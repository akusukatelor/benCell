<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('type'); // Nullable jika ada data lama
            // Jika ada kolom product_name, bisa drop nanti: $table->dropColumn('product_name');
        });

        // Jika ada data existing, isi product_id berdasarkan product_name (opsional)
        // Jalankan ini via Tinker setelah migrate jika perlu
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
    }
};
