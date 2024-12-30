<?php

use App\Models\User;

function get_auth_user(): User
{

    if (auth()->guest()) {
        throw new Exception('Unauthorized', 401);
    }

    return auth()->user();
}

function hitungJarak($lat1, $lon1, $lat2, $lon2) {
    // Konversi derajat ke radian
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    // Selisih latitude dan longitude
    $deltaLat = $lat2 - $lat1;
    $deltaLon = $lon2 - $lon1;

    // Rumus Haversine
    $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
         cos($lat1) * cos($lat2) *
         sin($deltaLon / 2) * sin($deltaLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    // Radius bumi dalam kilometer (mean radius = 6371 km)
    $radius = 6371;

    // Hitung jarak
    $jarak = $radius * $c;

    return $jarak;
}
