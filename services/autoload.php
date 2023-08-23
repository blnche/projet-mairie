<?php
    // Services
    require 'services/safeEcho.php';
    require 'services/weekStatusEcho.php';

    // Models
    require 'models/Address.php';
    require 'models/Association.php';
    require 'models/CafeteriaDate.php';
    require 'models/Child.php';
    require 'models/Event.php';
    require 'models/LocalProfessional.php';
    require 'models/Location.php';
    require 'models/MunicipalBulletin.php';
    require 'models/MunicipalCouncilReport.php';
    require 'models/Picture.php';
    require 'models/Post.php';
    require 'models/Project.php';
    require 'models/User.php';

    // Managers
    require 'managers/AbstractManager.php';
    require 'managers/UserManager.php';
    require 'managers/EventManager.php';
    require 'managers/MunicipalBulletinManager.php';
    require 'managers/MunicipalCouncilReportManager.php';
    require 'managers/AddressManager.php';
    require 'managers/ChildManager.php';
    require 'managers/CafeteriaDateManager.php';

    // Controllers
    require 'controllers/AbstractController.php';
    require 'controllers/UserController.php';
    require 'controllers/PageController.php';
    require 'controllers/FileController.php';
    require 'controllers/AuthenticationController.php';

    // Router
    require 'services/Router.php';
?>
