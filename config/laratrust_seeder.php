<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    /**
     * Added to allow a seeding of team names as well
     */
    'teams_list' => [
        'elliptic_works_llc',
        'pool_service_company_llc',
    ],

    'roles_structure' => [
        'elliptic_admin' => [

            'bumblebee_units' =>  'c,r,u,d',
            'bumblebee_data' =>  'c,r,u,d',

            'pool_clients' => 'c,r,u,d',
            'pool_client_locations' => 'c,r,u,d',
            'pool_client_bodies_of_water' => 'c,r,u,d',

            'elliptic_admin' => 'c,r,u,d',
            'elliptic_member' => 'c,r,u,d',

            'service_owner' => 'c,r,u,d',
            'service_manager' => 'c,r,u,d',
            'service_supervisor' => 'c,r,u,d',
            'service_scheduler' => 'c,r,u,d',
            'service_technician' => 'c,r,u,d',

            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'elliptic_member' => [
            'elliptic_member' => 'c,r,u,d',

            'bumblebee_units' =>  'c,r,u,d',
            'bumblebee_data' =>  'c,r,u,d',

            'users' => 'c,r,u,d',

            'profile' => 'r,u',
        ],
        'service_owner' => [
            'profile' => 'r,u',
        ],
        'user' => [
            'profile' => 'r,u',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
