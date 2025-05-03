<?php

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'id'; // Pastikan ini sesuai
    public $incrementing = true; // Pastikan true untuk auto-increment
    // ...

    // Konstanta untuk status
    const STATUS_PENDING = 'Pending';
    const STATUS_PENJEMPUTAN = 'Penjemputan';
    const STATUS_DIPROSES = 'Sedang Proses';
    const STATUS_SELESAI = 'Selesai';
    const STATUS_DIBATALKAN = 'Dibatalkan';

    // Daftar status dengan label
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Menunggu Konfirmasi',
            self::STATUS_PENJEMPUTAN => 'Penjemputan Barang',
            self::STATUS_DIPROSES => 'Dalam Perbaikan',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
        ];
    }


    // Scope untuk filter status selesai
    public function scopeSelesai($query)
    {
        return $query->where('status', self::STATUS_SELESAI);
    }

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
        return $this->hasMany(DamageDetails::class, 'order_id', 'id');
    }

    // Relasi dengan kurir
    public function kurir()
    {
        return $this->hasMany(Kurir::class);
    }
}
