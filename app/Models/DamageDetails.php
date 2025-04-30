<?php

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamageDetails extends Model
{
    protected $guarded = [];

    // Menentukan hubungan dengan model Kerusakan
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
