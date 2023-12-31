<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Order::index', ['filter' => 'auth']);

$routes->group('auth', function ($routes) {
    $routes->post('/', 'Auth::index');
    $routes->get('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
});

$routes->group('order', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Order::index');
    $routes->get('get-data', 'Order::getData');
});

$routes->group('information', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Information::index');
    $routes->get('get-data', 'Information::getData');
});

$routes->group('api', ['filter' => 'apiAuth', 'cors'], function ($routes) {
    $routes->get('order', 'Api\Order::index');

    $routes->group('information', function ($routes) {
        $routes->get('/', 'Api\Information::index');
        $routes->post('store', 'Api\Information::store');
    });
});
$routes->post('api/auth', 'Api\Auth::index', ['filter' => 'cors']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
