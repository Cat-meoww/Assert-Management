<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index', ['filter' => 'redirect_dashboard']);
$routes->get('redirect-to-dashboard', 'Login::user_dashboard');
$routes->get('/SharedWorker.js', 'General::shared_worker');
//server 
$routes->add('chatserver', 'Server::start_server');
//$routes->add('route/(:any)', 'Controller::method/$1');
$routes->group('auth', function ($routes) {
    $routes->add('login', 'Login::index', ['filter' => 'redirect_dashboard']);
    $routes->add('logout', 'Login::logout');
    $routes->add('register', 'Login::index');
    $routes->post('login/check', 'Login::auth_check');
});
$routes->group('global', function ($routes) {
    $routes->add('login', 'Login::index');
    $routes->add('chat', 'general::global_chat');
    $routes->add('inventory', 'general::admin_inventory');
});
$routes->group('admin', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->add('dashboard', 'admin::index');
    $routes->add('product-type', 'admin::create_product_type');
    $routes->add('product-category', 'admin::create_product_category');
    $routes->add('product-sub-category', 'admin::create_product_sub_category');
    $routes->add('create-product', 'admin::create_product');
    $routes->add('add-product', 'admin::add_product');
    $routes->add('create-ticket-titles', 'admin::create_ticket_titles');
    $routes->add('user-creation', 'admin::user_creation');
});
$routes->group('maintainer', ['namespace' => 'App\Controllers\Maintainer'], function ($routes) {
    $routes->add('dashboard', 'maintainer::index');
    $routes->add('my-assert', 'maintainer::assigned_assert');
    $routes->add('ticket', 'maintainer::ticket_view');
});
$routes->group('staff', ['namespace' => 'App\Controllers\Staff'], function ($routes) {
    $routes->add('dashboard', 'staff::index');
    $routes->add('my-assert', 'staff::assigned_assert');
    $routes->add('ticket', 'staff::ticket_view');
});
// $routes->group('all-master-save', function ($routes) {
//     $routes->post('product-type', 'General::post_create_product_type');
//     $routes->post('product-category', 'General::post_create_product_category');
//     $routes->post('product-sub-category', 'General::post_create_product_sub_category');
//     $routes->post('create-product', 'General::post_create_product');
//     $routes->post('create-ticket-titles', 'API\all_master::post_create_tickets_titles');
//     $routes->post('inventory', 'General::post_add_product');
//     $routes->post('maintainer-assign-update', 'General::post_update_assigner');
// });
$routes->group('all-master-save', ['namespace' => 'App\Controllers\API'], function ($routes) {
    $routes->post('product-type', 'all_master::post_create_product_type');
    $routes->post('product-category', 'all_master::post_create_product_category');
    $routes->post('product-sub-category', 'all_master::post_create_product_sub_category');
    $routes->post('create-product', 'all_master::post_create_product');
    $routes->post('create-ticket-titles', 'all_master::post_create_tickets_titles');
    $routes->post('inventory', 'all_master::post_add_product');
    $routes->post('maintainer-assign-update', 'all_master::post_update_assigner');
    $routes->post('user-creation', 'all_master::user_creation');
});
$routes->group('api', ['namespace' => 'App\Controllers\API'], static function ($routes) {
    $routes->add('show-product-datatable', 'general_api::product_datatable');
    $routes->add('show-admin-inventory-datatable', 'general_api::admin_inventory_datatable');
    $routes->add('show-maintainer-inventory-datatable', 'general_api::maintainer_inventory_datatable');
    $routes->add('show-staff-inventory-datatable', 'general_api::staff_inventory_datatable');
    $routes->post('update-product-status', 'general_api::update_product_status');
    $routes->post('update-repair-upgrade', 'general_api::update_repair_upgrade');
    $routes->post('get-assert-timeline', 'general_api::get_assert_timeline');
    $routes->post('post-ticket-raiser', 'general_api::raise_ticket');
    $routes->post('get-maintainer-tickets', 'general_api::lazy_maintainer_tickets');
    $routes->post('get-maintainer-tickets', 'general_api::lazy_maintainer_tickets');
    $routes->post('complete-ticket', 'general_api::complete_ticket');
    $routes->post('get_chat_data', 'general_api::get_chart_data');
});
$routes->group('api/dashboard', ['namespace' => 'App\Controllers\API'], static function ($routes) {
    $routes->add('get-ticket-report', 'Dashboard::ticket_chart');
    $routes->add('get-action-report', 'Dashboard::inventory_action');
});
$routes->group('api/admin', ['namespace' => 'App\Controllers\API'], static function ($routes) {
    $routes->post('show-users', 'Admin::UsersDataTable');
});

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
