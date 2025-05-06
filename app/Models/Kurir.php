<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;


    // app/Models/Kurir.php
    protected $fillable = [
        'name',
        'photo',
        'plat_motor',
        'merk_motor',
        'order_id',
        'phone',
        'status',
        'current_location'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    // protected $fillable = [
    //     'name',
    //     'photo',
    //     'plat_motor',
    //     'merk_motor',
    //     'order_id',
    // ];

    // // Relasi dengan tabel orders
    // public function order()
    // {
    //     return $this->belongsTo(Order::class);
    // }
}
