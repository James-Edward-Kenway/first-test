<?php
// sample configuration with fake values
return [
    // Get it in merchant's cabinet in cashbox settings
    'merchant_id' => '5c8dc37e5a9417ad4f1ce454',

    // Login is always "Paycom"
    'login'       => 'Paycom',

    // File with cashbox key (key can be found in cashbox settings)
    'keyFile'     => base_path('app/Http/Controllers/API/Paycom/password.paycom'),

    // Your database settings
    'db'          => [
        'host'     => 'localhost',
        'database' => 'asiagood',
        'username' => 'root',
        'password' => '',
    ],
];