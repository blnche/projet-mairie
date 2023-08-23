<?php
    session_start();

    require 'config/autoload.php';

    $router = new Router();
    if(isset($_GET['route']))
    {
        $router->checkRoute($_GET['route']);
    }
    else
    {
        $router->checkRoute('');
    }
?>