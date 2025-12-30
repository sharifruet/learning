<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

// Authentication routes
$routes->group('auth', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::attemptRegister');
    $routes->get('logout', 'Auth::logout');
    
    // OAuth routes
    $routes->get('google', 'Auth::google');
    $routes->get('google/callback', 'Auth::googleCallback');
    $routes->get('facebook', 'Auth::facebook');
    $routes->get('facebook/callback', 'Auth::facebookCallback');
});

// Dashboard routes (protected)
$routes->group('dashboard', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function($routes) {
    $routes->get('/', 'Dashboard::index');
});

// Course routes
$routes->group('courses', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'Course::index');
    $routes->get('(:num)', 'Course::view/$1');
    $routes->get('(:num)/module/(:num)', 'Course::module/$1/$2');
    $routes->get('(:num)/module/(:num)/lesson/(:num)', 'Lesson::view/$1/$2/$3');
    $routes->post('(:num)/module/(:num)/lesson/(:num)/exercise', 'Lesson::submitExercise/$1/$2/$3');
});

// Admin routes (protected)
$routes->group('admin', ['namespace' => 'App\Controllers', 'filter' => 'auth:admin'], function($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('courses', 'Admin\Course::index');
    $routes->get('courses/create', 'Admin\Course::create');
    $routes->post('courses/store', 'Admin\Course::store');
    $routes->get('courses/(:num)/edit', 'Admin\Course::edit/$1');
    $routes->post('courses/(:num)/update', 'Admin\Course::update/$1');
    $routes->get('lessons', 'Admin\Lesson::index');
    $routes->get('lessons/create', 'Admin\Lesson::create');
    $routes->post('lessons/store', 'Admin\Lesson::store');
});

