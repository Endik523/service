<?php

// app/Models/Kerusakan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerusakan extends Model
{
    use HasFactory;

    // Menentukan kolom-kolom yang dapat diisi
    protected $fillable = ['kerusakan', 'order_id'];

    // Menentukan hubungan antara Kerusakan dan Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

