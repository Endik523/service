<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Untuk tabel orders
        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id'); // Foreign key
            $table->index('status'); // Sering difilter
            $table->index('id_random'); // Sering di-search
            $table->index('tgl_pesan'); // Sering di-sort
        });

        // Untuk tabel damage_details
        Schema::table('damage_details', function (Blueprint $table) {
            $table->index('order_id'); // Foreign key
        });

        // Untuk tabel kurirs
        Schema::table('kurirs', function (Blueprint $table) {
            $table->index('order_id'); // Foreign key
        });
    }

    public function down()
    {
        // Untuk rollback
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['id_random']);
            $table->dropIndex(['tgl_pesan']);
        });

        Schema::table('damage_details', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
        });

        Schema::table('kurirs', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
        });
    }
};
