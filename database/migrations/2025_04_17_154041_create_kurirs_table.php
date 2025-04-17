<?php

// database/migrations/YYYY_MM_DD_HHMMSS_create_kurirs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKurirsTable extends Migration
{
    /**
     * Jalankan migration untuk membuat tabel kurirs.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kurirs', function (Blueprint $table) {
            $table->id(); // Kolom id auto increment
            $table->string('name'); // Nama kurir
            $table->string('photo')->nullable(); // Foto kurir (URL)
            $table->string('plat_motor'); // Plat motor
            $table->string('merk_motor'); // Merk motor
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relasi dengan tabel orders
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Balikan perubahan yang dilakukan oleh migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kurirs');
    }
};
