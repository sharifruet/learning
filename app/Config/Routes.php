<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

// Public file access
$routes->get('uploads/images/(:segment)', function($filename) {
    $filePath = WRITEPATH . 'uploads/images/' . $filename;
    if (file_exists($filePath)) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);
        
        header('Content-Type: ' . $mimeType);
        readfile($filePath);
        exit;
    }
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
});

// Authentication routes
$routes->group('auth', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::attemptRegister');
    $routes->get('logout', 'Auth::logout');
    
    // Email verification routes
    $routes->get('verify-email/(:segment)', 'Auth::verifyEmail/$1');
    $routes->get('resend-verification', 'Auth::resendVerification');
    $routes->post('resend-verification', 'Auth::processResendVerification');
    
    // Password reset routes
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('forgot-password', 'Auth::requestPasswordReset');
    $routes->get('reset-password/(:segment)', 'Auth::resetPassword/$1');
    $routes->post('reset-password', 'Auth::processPasswordReset');
    
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

// Shortcut routes for popular courses (must be before course routes)
$routes->get('python', 'Home::python');
$routes->get('javascript', 'Home::javascript');

// Course routes (public - browsable without login)
// Using slugs for better SEO and user-friendly URLs
$routes->group('courses', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'Course::index');
    $routes->get('(:segment)', 'Course::view/$1'); // Course slug
    $routes->get('(:segment)/module/(:num)', 'Course::module/$1/$2'); // Course slug, module ID
    $routes->get('(:segment)/module/(:num)/lesson/(:num)', 'Lesson::view/$1/$2/$3'); // Course slug, module ID, lesson ID
    $routes->post('(:segment)/module/(:num)/lesson/(:num)/exercise', 'Lesson::submitExercise/$1/$2/$3');
    $routes->post('(:segment)/module/(:num)/lesson/(:num)/bookmark', 'Lesson::toggleBookmark/$1/$2/$3', ['filter' => 'auth']);
    $routes->post('(:segment)/module/(:num)/lesson/(:num)/complete', 'Lesson::markComplete/$1/$2/$3', ['filter' => 'auth']);
    $routes->post('(:segment)/module/(:num)/lesson/(:num)/track-time', 'Lesson::trackTime/$1/$2/$3', ['filter' => 'auth']);
});

// Enrollment routes (requires authentication) - using course slug
$routes->group('enroll', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function($routes) {
    $routes->post('(:segment)', 'Enrollment::enroll/$1'); // Course slug
    $routes->post('(:segment)/unenroll', 'Enrollment::unenroll/$1'); // Course slug
});

// Instructor routes (protected - instructor and admin)
$routes->group('instructor', ['namespace' => 'App\Controllers', 'filter' => 'auth:instructor,admin'], function($routes) {
    $routes->get('/', 'Instructor\Dashboard::index');
});

// Admin routes (protected - admin only)
$routes->group('admin', ['namespace' => 'App\Controllers', 'filter' => 'auth:admin'], function($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    
    // Course routes
    $routes->get('courses', 'Admin\Course::index');
    $routes->get('courses/create', 'Admin\Course::create');
    $routes->post('courses/store', 'Admin\Course::store');
    $routes->get('courses/(:num)/edit', 'Admin\Course::edit/$1');
    $routes->post('courses/(:num)/update', 'Admin\Course::update/$1');
    
    // Module routes
    $routes->get('courses/(:num)/modules', 'Admin\Module::index/$1');
    $routes->get('modules/create', 'Admin\Module::create');
    $routes->get('modules/create/(:num)', 'Admin\Module::create/$1');
    $routes->post('modules/store', 'Admin\Module::store');
    $routes->get('modules/(:num)/edit', 'Admin\Module::edit/$1');
    $routes->post('modules/(:num)/update', 'Admin\Module::update/$1');
    $routes->get('modules/(:num)/delete', 'Admin\Module::delete/$1');
    
    // Lesson routes
    $routes->get('lessons', 'Admin\Lesson::index');
    $routes->get('lessons/create', 'Admin\Lesson::create');
    $routes->get('lessons/create/(:num)', 'Admin\Lesson::create/$1');
    $routes->post('lessons/store', 'Admin\Lesson::store');
    $routes->get('lessons/(:num)/edit', 'Admin\Lesson::edit/$1');
    $routes->post('lessons/(:num)/update', 'Admin\Lesson::update/$1');
    $routes->get('lessons/(:num)/delete', 'Admin\Lesson::delete/$1');
    
    // File upload routes
    $routes->post('upload/image', 'Admin\FileUpload::uploadImage');
    
    // Exercise routes
    $routes->get('exercises', 'Admin\Exercise::index');
    $routes->get('exercises/(:num)', 'Admin\Exercise::index/$1');
    $routes->get('exercises/create', 'Admin\Exercise::create');
    $routes->get('exercises/create/(:num)', 'Admin\Exercise::create/$1');
    $routes->post('exercises/store', 'Admin\Exercise::store');
    $routes->get('exercises/(:num)/edit', 'Admin\Exercise::edit/$1');
    $routes->post('exercises/(:num)/update', 'Admin\Exercise::update/$1');
    $routes->get('exercises/(:num)/delete', 'Admin\Exercise::delete/$1');
    
    // User management routes
    $routes->get('users', 'Admin\User::index');
    $routes->get('users/(:num)/edit', 'Admin\User::edit/$1');
    $routes->post('users/(:num)/update', 'Admin\User::update/$1');
    $routes->get('users/(:num)/delete', 'Admin\User::delete/$1');
    
    // API routes
    $routes->get('api/modules/(:num)', 'Admin\Api::getModules/$1');
});

