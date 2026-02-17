<?php

return [
    'self_mark' => [
        // 24-hour format. Students can self-mark only inside this range.
        'window_start' => env('ATTENDANCE_SELF_MARK_START', '07:00'),
        'window_end' => env('ATTENDANCE_SELF_MARK_END', '21:00'),

        // Keep empty to allow all networks. Example: "127.0.0.1,192.168.1.10"
        'allowed_ips' => array_filter(array_map('trim', explode(',', (string) env('ATTENDANCE_SELF_MARK_ALLOWED_IPS', '')))),
    ],
];
