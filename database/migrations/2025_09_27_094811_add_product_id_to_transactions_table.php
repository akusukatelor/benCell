<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       Schema::table('transactions', function (Blueprint $table) {
    if (!Schema::hasColumn('transactions', 'product_id')) {
        $table->unsignedBigInteger('product_id')->nullable()->after('type');
    }
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
