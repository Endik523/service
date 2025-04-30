<?php

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatOrder extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'id'; // Pastikan ini sesuai
    public $incrementing = true; // Pastikan true untuk auto-increment
    // ...

    // Konstanta untuk status
    const STATUS_PENDING = 'pending';
    const STATUS_PENJEMPUTAN = 'penjemputan';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';

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
