<?php

require_once 'Routing.php';
require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/ProfileController.php';
require_once 'src/controllers/AdminController.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('home', 'DefaultController');
Router::get('login', 'SecurityController');
Router::post('login', 'SecurityController');
Router::get('register', 'SecurityController');
Router::post('register', 'SecurityController');
Router::get('logout', 'DefaultController');
Router::get('placeBet', 'DefaultController');
Router::get('profile', 'ProfileController');
Router::post('changePassword', 'ProfileController');
Router::post('deleteAccount', 'ProfileController');
Router::get('adminMenu', 'AdminController');
Router::get('addEvent', 'AdminController');
Router::post('addEvent', 'AdminController');
Router::post('deleteEvent', 'AdminController');
Router::post('finishEvent', 'AdminController');


Router::run($path);
