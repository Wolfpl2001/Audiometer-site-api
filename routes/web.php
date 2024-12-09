<?php
use Core\Framework;
use App\Middleware\AuthenticationMiddleware;
use App\Middleware\AdminAuthenticationMiddleware;

$app = new Framework();

$app::get('/', 'HomeController', 'welcome');
$app::get('/login', 'HomeController', 'login');
$app::post('/login', 'HomeController', 'authenticate');

$app::get('/register', 'HomeController', 'register', AdminAuthenticationMiddleware::class);
$app::post('/processRegistration', 'HomeController', 'processRegistration', AdminAuthenticationMiddleware::class);
$app::get('/manageusers', 'HomeController', 'manageUsers', AdminAuthenticationMiddleware::class);

$app::get('/edit-user', 'HomeController', 'editUser', AdminAuthenticationMiddleware::class);
$app::post('/update-user', 'HomeController', 'updateUser', AdminAuthenticationMiddleware::class);
$app::get('/delete-user', 'HomeController', 'deleteUser', AdminAuthenticationMiddleware::class);

// Protected routes with Middleware
$app::get('/loginafter', 'HomeController', 'loginafter', AuthenticationMiddleware::class);
$app::get('/logout', 'HomeController', 'logout', AuthenticationMiddleware::class);

//$app::get('/api/test', 'APIController', 'testAPI');
$app::post('/api/key/check', 'APIController', 'getAPIKey');



$app->run();
