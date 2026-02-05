<?php

return [
    'menu' => [
        [
            'title'  => 'Dashboards',
            'icon'   => 'ri-dashboard-2-line',
            'id'     => 'sidebarDashboards',
            'key'    => 't-dashboards',
            'active' => ['home', 'dashboard*'], 
            'submenu' => [
                ['route' => 'home', 'label' => 'Projects', 'key' => 't-projects']
            ]
        ],
        [
            'title'  => 'Apps',
            'icon'   => 'ri-apps-2-line',
            'id'     => 'sidebarApps',
            'key'    => 't-apps',
            'active' => ['apps-project*', 'apps-task*'],
            'submenu' => [
                [
                    'title'  => 'Projects',
                    'id'     => 'sidebarProjects',
                    'key'    => 't-projects',
                    'active' => ['apps-project*'],
                    'items'  => [
                        ['route' => 'apps-project/list',      'label' => 'List',           'key' => 't-list'],
                        ['route' => 'apps-project/overview',  'label' => 'Overview',       'key' => 't-overview'],
                        ['route' => 'apps-project/create',    'label' => 'Create Project', 'key' => 't-create'],
                    ]
                ],
                [
                    'title'  => 'Tasks',
                    'id'     => 'sidebarTasks',
                    'key'    => 't-task',
                    'active' => ['apps-task*'],
                    'items'  => [
                        ['route' => 'apps-task/kanban-board',  'label' => 'Kanban Board', 'key' => 't-kanban-board'],
                        ['route' => 'apps-task/list-view',     'label' => 'List View',    'key' => 't-list-view'],
                        ['route' => 'apps-task/task-details',  'label' => 'Task Details', 'key' => 't-task-details'],
                    ]
                ]
            ]
        ],
        [
            'title'  => 'Pages',
            'icon'   => 'ri-pages-line',
            'id'     => 'sidebarPages',
            'key'    => 't-pages',
            'active' => ['pages*'],
            'submenu' => [
                [
                    'title'  => 'Profile',
                    'id'     => 'sidebarProfile',
                    'key'    => 't-profile',
                    'active' => ['pages/*'],
                    'items'  => [
                        ['route' => 'pages/profile', 'label' => 'Simple Page', 'key' => 't-simple-page'],
                        ['route' => 'pages/settings', 'label' => 'Settings',   'key' => 't-settings'],
                    ]
                ],
                ['route' => 'pages/faqs', 'label' => 'FAQs', 'key' => 't-faqs']
            ]
        ]
    ]
];