<?php
    session_start();

    /*require 'managers/UserManager.php';
    require 'managers/EventManager.php';
    require 'managers/MunicipalBulletinManager.php';
    require 'managers/MunicipalCouncilReportManager.php';
    // require 'managers/AddressManager.php'; can't call it or bugs maybe because it's already call inside other managers ?


    require 'controllers/UserController.php';
    require 'controllers/PageController.php';
    require 'controllers/FileController.php';

    require 'services/Router.php';*/

    require 'services/autoload.php';

    $router = new Router();
    $router->checkRoute();
?>