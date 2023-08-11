<?php
    session_start();

    require 'managers/UserManager.php';
    require 'managers/EventManager.php';
    // require 'managers/AddressManager.php';

    require 'controllers/UserController.php';
    require 'controllers/PageController.php';

    require 'services/Router.php';
?>