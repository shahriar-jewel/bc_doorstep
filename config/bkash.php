<?php

// BKash configuration

return [
    // For Sandbox, use "https://checkout.sandbox.bka.sh/v1.2.0-beta"
    // For Live, use "https://checkout.sandbox.bka.sh/v1.2.0-beta"

    'sandbox' => [
        'apiBaseURL' => env("BKASH_API_BASE_URL", "https://checkout.sandbox.bka.sh/v1.2.0-beta"),
        'apiCredentials' => [
            'app_key' => env("BKASH_APP_KEY","5nej5keguopj928ekcj3dne8p"),
            'app_secret' => env("BKASH_APP_SECRET","1honf6u1c56mqcivtc9ffl960slp4v2756jle5925nbooa46ch62"),
            'username' => env("BKASH_USERNAME","testdemo"),
            'password' => env("BKASH_PASSWORD","test%#de23@msdao"),
        ],
        'apiUrl' => [
            'grant_token' => "/checkout/token/grant",
            'refresh_token' => "/checkout/token/refresh",
            'create_payment' => "/checkout/payment/create",
            'execute_payment' => "/checkout/payment/execute/",
            'query_payment' => "/checkout/payment/query/",
            'search_transaction' => "/checkout/payment/search/",
            'refund_payment' => "/checkout/payment/refund",
            'refund_status' => "/checkout/payment/refund",
        ],
    ],
    'production' => [
        'apiBaseURL' => env("BKASH_API_BASE_URL", "https://checkout.sandbox.bka.sh/v1.2.0-beta"),
        'apiCredentials' => [
            'app_key' => env("BKASH_APP_KEY","5tunt4masn6pv2hnvte1sb5n3j"),
            'app_secret' => env("BKASH_APP_SECRET","1vggbqd4hqk9g96o9rrrp2jftvek578v7d2bnerim12a87dbrrka"),
            'username' => env("BKASH_USERNAME","sandboxTestUser"),
            'password' => env("BKASH_PASSWORD","hWD@8vtzw0"),
        ],
        'apiUrl' => [
            'grant_token' => "/checkout/token/grant",
            'refresh_token' => "/checkout/token/refresh",
            'create_payment' => "/checkout/payment/create",
            'execute_payment' => "/checkout/payment/execute/",
            'query_payment' => "/checkout/payment/query/",
            'search_transaction' => "/checkout/payment/search/",
            'refund_payment' => "/checkout/payment/refund",
            'refund_status' => "/checkout/payment/refund",
        ],
    ],
    
    'connect_from_localhost' => env("BKASH_IS_SANDBOX", true), // For Sandbox, use "true", For Live, use "false"

    'sandbox_web' => [
        'apiBaseURL' => env("BKASH_API_BASE_URL", "https://checkout.sandbox.bka.sh/v1.2.0-beta"),
        'apiCredentials' => [
            'app_key' => env("BKASH_APP_KEY","5nej5keguopj928ekcj3dne8p"),
            'app_secret' => env("BKASH_APP_SECRET","1honf6u1c56mqcivtc9ffl960slp4v2756jle5925nbooa46ch62"),
            'username' => env("BKASH_USERNAME","testdemo"),
            'password' => env("BKASH_PASSWORD","test%#de23@msdao"),
        ],
        'apiUrl' => [
            'grant_token' => "/checkout/token/grant",
            'refresh_token' => "/checkout/token/refresh",
            'create_payment' => "/checkout/payment/create",
            'execute_payment' => "/checkout/payment/execute/",
            'query_payment' => "/checkout/payment/query/",
            'search_transaction' => "/checkout/payment/search/",
            'refund_payment' => "/checkout/payment/refund",
            'refund_status' => "/checkout/payment/refund",
        ],
    ],

    'production_web' => [
        'apiBaseURL' => env("BKASH_API_BASE_URL", "https://checkout.pay.bka.sh/v1.2.0-beta"),
        'apiCredentials' => [
            'app_key' => env("BKASH_APP_KEY","5gtehrgp06ivbcphqbsjtkobnv"),
            'app_secret' => env("BKASH_APP_SECRET","1rm764e2a8gqv2svfk6e7ss51su3s7cpamn30jmrhf0efeiiasn7"),
            'username' => env("BKASH_USERNAME","BURGERKINGWEB"),
            'password' => env("BKASH_PASSWORD","ti1f@in8LrM4uK"),
        ],
        'apiUrl' => [
            'grant_token' => "/checkout/token/grant",
            'refresh_token' => "/checkout/token/refresh",
            'create_payment' => "/checkout/payment/create",
            'execute_payment' => "/checkout/payment/execute/",
            'query_payment' => "/checkout/payment/query/",
            'search_transaction' => "/checkout/payment/search/",
            'refund_payment' => "/checkout/payment/refund",
            'refund_status' => "/checkout/payment/refund",
        ],
    ],
    
];