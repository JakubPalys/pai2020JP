<?php
require_once 'src/controllers/AppController.php';


$path = $_SERVER['REQUEST_URI'];

var_dump($path);

if ($path == '/dashboard') {
    $controller = new AppController();
    $controller->render('dashboard');
}
else {
    echo 'Hi there students 👋';
}
