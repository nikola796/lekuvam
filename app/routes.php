<?php

$router->get('', array('App\Controllers\PagesController', 'home'));

$router->get('home', array('App\Controllers\PagesController', 'home'));

$router->get('about', array('App\Controllers\PagesController', 'about'));

$router->get('login', array('App\Controllers\PagesController', 'login'));

//$router->get('register', array('App\Controllers\CustomerController', 'register'));

$router->get('users/{id}', array('App\Controllers\CustomerController', 'getUser'));

$router->get('users', array('App\Controllers\CustomerController', 'getUsers'));

$router->get('success', array('App\Controllers\PagesController', 'success'));

$router->get('register', array('App\Controllers\PagesController', 'register'));

$router->get('logout', array('App\Controllers\AuthController', 'logout'));

// POST routes
$router->post('login', array('App\Controllers\CustomerController', 'login'));

$router->post('register', array('App\Controllers\CustomerController', 'register'));

$router->filter('auth', array('App\Controllers\AuthController', 'session_start'));

$router->post('save-post', array('App\Controllers\CustomerController', 'savePost'));