<?php

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    // Menentukan hubungan dengan model Kerusakan
    public function kerusakans()
    {
        return $this->hasMany(Kerusakan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    // Di model Order
    public function damageDetails()
    {
        return $this->hasMany(DamageDetails::class, 'id_order', 'id');
    }

    // Relasi dengan kurir
    public function kurir()
    {
        return $this->hasMany(Kurir::class);
    }
}
