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
        Schema::create('damage_details', function (Blueprint $table) {
            $table->id();                             // Auto Increment ID
            $table->unsignedBigInteger('id_order');    // Foreign Key untuk orders
            $table->string('nama_barang');             // Nama barang yang rusak
            $table->decimal('harga_barang', 10, 2);    // Harga barang yang rusak
            $table->foreign('id_order')->references('id')->on('orders')->onDelete('cascade'); // Foreign key constraint
            $table->timestamps();                     // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_details');
    }
};
