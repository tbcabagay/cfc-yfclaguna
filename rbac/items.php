<?php
return [
    'viewAnnouncement' => [
        'type' => 2,
        'description' => 'View announcements',
    ],
    'commentPost' => [
        'type' => 2,
        'description' => 'Comment on a post',
    ],
    'createAnnouncement' => [
        'type' => 2,
        'description' => 'Create an announcement',
    ],
    'updatePost' => [
        'type' => 2,
        'description' => 'Update post',
    ],
    'deletePost' => [
        'type' => 2,
        'description' => 'Delete post',
    ],
    'updateOwnPost' => [
        'type' => 2,
        'description' => 'Update own post',
        'ruleName' => 'isAuthor',
        'children' => [
            'updatePost',
        ],
    ],
    'deleteOwnPost' => [
        'type' => 2,
        'description' => 'Update own post',
        'ruleName' => 'isAuthor',
        'children' => [
            'deletePost',
        ],
    ],
    'createDocument' => [
        'type' => 2,
        'description' => 'Create a document',
    ],
    'createUser' => [
        'type' => 2,
        'description' => 'Create a user',
    ],
    'createService' => [
        'type' => 2,
        'description' => 'Create a service',
    ],
    'createDivision' => [
        'type' => 2,
        'description' => 'Create a service',
    ],
    'member' => [
        'type' => 1,
        'children' => [
            'viewAnnouncement',
            'commentPost',
        ],
    ],
    'couple_coordinator' => [
        'type' => 1,
        'children' => [
            'member',
            'createAnnouncement',
            'createUser',
            'createService',
            'createDivision',
            'createDocument',
            'updateOwnPost',
            'deleteOwnPost',
        ],
    ],
    'head' => [
        'type' => 1,
        'children' => [
            'couple_coordinator',
            'updatePost',
            'deletePost',
        ],
    ],
];
