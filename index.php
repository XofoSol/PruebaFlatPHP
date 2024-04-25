<?php
require_once 'vendor/autoload.php';
use Library\Router;

$url = $_SERVER['REQUEST_URI'];
Router::manage($url);