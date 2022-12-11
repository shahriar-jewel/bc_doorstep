<?php

return [
    'production' => [
         'apiBaseURL' => env("PENSION_API_BASE_URL", "http://www.dhakasoft.net/myWeb03/api/Member?apikey=bclsinglemeber001&"),
        'authorizationHeader' => [
            'username' => "BTRAC",
            'password' => "BTRACEEF47D9A-DBA9-4D12-B7BB-04F4279A2020",
        ],
        'userCredentials' => [
            'grant_type' => "password",
            'username'   => "btrac",
            'password'   => "bangladesh",
        ],
        'apiUrl' => [
            'access_token' => "/token",
            'dataapi' => "/Pension/GetPensionerForBTrac?",
        ],
    ]
];