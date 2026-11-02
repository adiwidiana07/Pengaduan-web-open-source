<?php

return [

    /*
    | Kunci HMAC untuk menyamarkan identitas penulis dan pelapor.
    | Tabel aspirasi dan laporan hanya menyimpan hash, tidak pernah user_id,
    | sehingga admin tidak bisa menghubungkan aspirasi ke akun.
    | Mengganti atau kehilangan kunci ini memutus kepemilikan semua aspirasi.
    | Buat dengan: php artisan identity:key
    */
    'identity_key' => env('IDENTITY_HASH_KEY'),

    // Jumlah laporan minimal sebelum admin boleh menghapus sebuah aspirasi.
    'report_threshold' => (int) env('REPORT_THRESHOLD', 50),

    'report_reasons' => [
        'spam' => 'Spam atau promosi',
        'ujaran_kebencian' => 'Ujaran kebencian atau SARA',
        'informasi_palsu' => 'Informasi palsu',
        'data_pribadi' => 'Menyebarkan data pribadi orang lain',
        'lainnya' => 'Lainnya',
    ],

];
