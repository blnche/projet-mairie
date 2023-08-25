<?php
session_start();

require 'config/autoload.php';

$router = new Router2();

if (isset($_GET['path'])) {
    echo 'path ok';
    $router->checkRoute($_GET['path']);
} else {
    $router->checkRoute('');
}
?>