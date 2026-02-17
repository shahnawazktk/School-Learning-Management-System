<?php

return [
    'channels' => [
        'easypaisa' => [
            'label' => env('FEE_CHANNEL_EASYPAISA_LABEL', 'EasyPaisa'),
            'icon' => 'fas fa-mobile-screen-button',
            'icon_color' => 'text-success',
            'line1' => 'Account: ' . env('FEE_CHANNEL_EASYPAISA_ACCOUNT', '03XX-XXXXXXX'),
            'line2' => 'Title: ' . env('FEE_CHANNEL_EASYPAISA_TITLE', 'School LMS'),
        ],
        'jazzcash' => [
            'label' => env('FEE_CHANNEL_JAZZCASH_LABEL', 'JazzCash'),
            'icon' => 'fas fa-wallet',
            'icon_color' => 'text-warning',
            'line1' => 'Account: ' . env('FEE_CHANNEL_JAZZCASH_ACCOUNT', '03YY-YYYYYYY'),
            'line2' => 'Title: ' . env('FEE_CHANNEL_JAZZCASH_TITLE', 'School LMS'),
        ],
        'bank_transfer' => [
            'label' => env('FEE_CHANNEL_BANK_LABEL', 'Bank Transfer'),
            'icon' => 'fas fa-building-columns',
            'icon_color' => 'text-primary',
            'line1' => 'Bank: ' . env('FEE_CHANNEL_BANK_NAME', 'ABC Bank'),
            'line2' => 'IBAN: ' . env('FEE_CHANNEL_BANK_IBAN', 'PK00ABCD0000000000000000'),
        ],
    ],
];
