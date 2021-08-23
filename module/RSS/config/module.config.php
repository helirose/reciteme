<?php

declare(strict_types=1);

namespace RSS;

use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'rss' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/rss[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\RSSController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
