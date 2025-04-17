<?php

// database/migrations/YYYY_MM_DD_HHMMSS_create_couriers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKurirTable extends Migration
{
    /**
     * Jalankan migration untuk membuat tabel couriers.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kurir', function (Blueprint $table) {
            $table->id(); // Menambahkan kolom id (auto increment)
            $table->string('name'); // Nama kurir
            $table->string('photo')->nullable(); // Foto kurir (nullable jika foto tidak wajib)
            $table->string('plat_motor'); // Plat motor
            $table->string('merk_motor'); // Merk motor
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relasi ke tabel orders, jika order dihapus, data kurir juga ikut dihapus
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }

    /**
     * Balikan perubahan yang dilakukan oleh migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kurir');
    }
};
