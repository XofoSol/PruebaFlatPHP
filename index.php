<?php
require_once 'vendor/autoload.php';
use Library\Router;

// Obtenemos la url, y se la enviamos al router para que la procese
$url = $_SERVER['REQUEST_URI'];
Router::manage($url);