<?php

// database/migrations/xxxx_xx_xx_create_kerusakans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKerusakansTable extends Migration
{
    public function up()
    {
        Schema::create('kerusakans', function (Blueprint $table) {
            $table->id();
            $table->text('kerusakan'); // Deskripsi kerusakan
            $table->unsignedBigInteger('order_id'); // Menyimpan ID order yang terkait
            $table->timestamps();

            // Menambahkan foreign key untuk order_id yang merujuk ke tabel orders
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kerusakans');
    }
}
