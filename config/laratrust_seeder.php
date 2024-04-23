<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => false,

    'roles_structure' => [
        'owner' => [
            'users' => 'c,r,u,d',
            'businesses' => 'c,r,u,d',
            'business_categories' => 'c,r,u,d',
            'product_categories' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'product_discounts' => 'c,r,u,d',
            'product_reviews' => 'r,u,d',
            'product_stocks' => 'c,r,u,d',
            'orders' => 'r',
            'promo_codes' => 'c,r,u,d',
            'statistics' => 'r'
        ],
        'admin' => [
            'users' => 'c,r,u,d',
            'businesses' => 'c,r,u,d',
            'business_categories' => 'c,r,u,d',
            'product_categories' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'product_discounts' => 'c,r,u,d',
            'product_reviews' => 'r,u,d',
            'product_stocks' => 'c,r,u,d',
            'orders' => 'r',
            'transactions' => 'r',
            'promo_codes' => 'c,r,u,d',
            'statistics' => 'r'
        ],
        'business_owner' => [
            'users' => 'c,r,u,d',
            'product_categories' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'product_discounts' => 'c,r,u,d',
            'product_reviews' => 'r,u,d',
            'product_stocks' => 'c,r,u,d',
            'orders' => 'r',
            'promo_codes' => 'c,r,u,d',
            'statistics' => 'r'
        ],
        'business_admin' => [
            'users' => 'c,r,u,d',
            'product_categories' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'product_discounts' => 'c,r,u,d',
            'product_reviews' => 'r,u,d',
            'product_stocks' => 'c,r,u,d',
            'orders' => 'r',
            'promo_codes' => 'c,r,u,d',
            'statistics' => 'r'
        ],
        'business_member' => [
            'users' => 'c,r,u,d',
            'product_categories' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'product_discounts' => 'c,r,u,d',
            'product_reviews' => 'r,u,d',
            'product_stocks' => 'c,r,u,d',
            'orders' => 'r',
            'promo_codes' => 'c,r,u,d',
            'statistics' => 'r'
        ]
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'e' => 'export'
    ],
];
