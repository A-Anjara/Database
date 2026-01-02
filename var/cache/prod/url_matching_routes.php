<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/database' => [[['_route' => 'app_database', '_controller' => 'App\\Controller\\DatabaseController::index'], null, null, null, false, false, null]],
        '/export' => [[['_route' => 'export', '_controller' => 'App\\Controller\\DatabaseController::export'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'access', '_controller' => 'App\\Controller\\IndexController::acces'], null, null, null, false, false, null]],
        '/logout' => [[['_route' => 'logout', '_controller' => 'App\\Controller\\IndexController::logout'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/info(?:/([^/]++))?(*:26)'
                .'|/transaction(?:/([^/]++))?(*:59)'
                .'|/parrainage(?:/([^/]++))?(*:91)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        26 => [[['_route' => 'fetch_user_info', 'id' => 1, '_controller' => 'App\\Controller\\DatabaseController::get_user_info'], ['id'], null, null, false, true, null]],
        59 => [[['_route' => 'fetch_user_transaction', 'id' => 1, '_controller' => 'App\\Controller\\DatabaseController::get_user_transaction'], ['id'], null, null, false, true, null]],
        91 => [
            [['_route' => 'fetch_user_parrainage', 'id' => 1, '_controller' => 'App\\Controller\\DatabaseController::get_user_parrainage'], ['id'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
