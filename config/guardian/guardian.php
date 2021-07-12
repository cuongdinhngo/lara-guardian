<?php

return [
    /*
     * The models you will use to implement the Guardian
     */
    'models' => [
        'actions' => App\Models\Action::class,

        'pages' => App\Models\Page::class,

        'roles' => App\Models\Role::class,

        'groups' => App\Models\Group::class,

        'permissions' => App\Models\Permission::class,
    ],
    /*
     * UPSERT methods
     *
     * actions.insert: the column(s) that uniquely identify records within the associated table
     * actions.update: the columns that should be updated if a matching record already exists in the database
     *
     */
    'upsert' => [
        'actions' => [
            'insert' => ['id', 'name', 'alias'],
            'update' => ['name', 'alias'],
        ],
        'pages' => [
            'insert' => ['id', 'name', 'alias'],
            'update' => ['name', 'alias'],
        ],
        'groups' => [
            'insert' => ['id', 'name', 'alias'],
            'update' => ['name', 'alias'],
        ],
    ]
];
