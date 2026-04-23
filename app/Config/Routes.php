<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- FRONTEND ROUTES ---
$routes->get('/', 'Home::index');
$routes->get('history', 'Home::history');

// --- AUTH ROUTES ---
$routes->get('auth/login', 'Auth::login');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/store', 'Auth::store');
$routes->post('auth/attempt', 'Auth::attempt');
$routes->get('auth/logout', 'Auth::logout');

// --- USER DASHBOARD & TOPUP (PROTECTED) ---
$routes->group('user', ['namespace' => 'App\Controllers\User', 'filter' => 'admin_filter'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('topup', 'Topup::index');
    $routes->post('topup/generate', 'Topup::generate');
    $routes->post('purchase', 'Purchase::order');
});

// --- ADMIN PANEL (PROTECTED) ---
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'admin_filter'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');

    // Product Management
    $routes->get('products', 'ProductController::index');
    $routes->post('products/store', 'ProductController::store');
    $routes->post('products/update/(:num)', 'ProductController::update/$1');
    $routes->post('products/update_quick', 'ProductController::update_quick');
    $routes->get('products/delete/(:num)', 'ProductController::delete/$1');

    // Account Inventory (Gudang Akun)
    $routes->get('accounts', 'AccountController::index');
    $routes->post('accounts/bulk_store', 'AccountController::bulk_store');
    $routes->get('accounts/delete/(:num)', 'AccountController::delete/$1');

    // Order & Settings
    $routes->get('orders', 'OrderController::index');
    $routes->get('orders/status/(:num)/(:any)', 'OrderController::update_status/$1/$2');
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
    $routes->get('settings', 'Settings::index');
    $routes->post('settings/update', 'Settings::update');
});
