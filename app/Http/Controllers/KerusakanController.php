<?php

// app/Http/Controllers/KerusakanController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

class KerusakanController extends Controller
{
    // Menampilkan status kerusakan berdasarkan order ID
   // app/Http/Controllers/KerusakanController.php

    // app/Http/Controllers/KerusakanController.php
    public function showKerusakan($id)
        {
            $order = Order::find($id);  // Mengambil data order berdasarkan ID yang diberikan
            if (!$order) {
                abort(404, "Order not found");
            }

            $kerusakan = $order->kerusakans;  // Mengambil kerusakan yang terkait dengan order ini

            return view('status', compact('kerusakan', 'order'));  // Mengirim 'order' dan 'kerusakan' ke view
        }


}
