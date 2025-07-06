<?php



namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case KURIR = 'kurir';
    case TEKNISI = 'teknisi';

    public static function values(): array
    {
        return [
            self::ADMIN->value,
            self::USER->value,
            self::KURIR->value,
            self::TEKNISI->value,
        ];
    }
}



// app/Enums/Role.php
// namespace App\Enums;

// enum Role: string
// {
//     case ADMIN = 'admin';
//     case USER = 'user';
// }
