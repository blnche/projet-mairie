<?php 
    class Router {
        private UserController $userController;
        private PageController $pageController;
        private FileController $fileController;
        private AuthenticationController $authenticationController;

        public function __construct()
        {
            $this->userController = new UserController();
            $this->pageController = new PageController();
            $this->fileController = new FileController();
            $this->authenticationController = new AuthenticationController();
        }

        public function checkRoute() : void
        {
            if (isset($_GET['route']))
            {
                $route = $_GET['route'];

                // AUTHENTICATION
                if ($route === 'register')
                {
                    $this->authenticationController->register();
                }
                else if ($route === 'login')
                {
                    $this->authenticationController->login();
                }
                else if ($route === 'logout')
                {
                    $this->authenticationController->logout();
                }

                // PUBLIC
                else if ($route === 'accueil')
                {
                    $this->pageController->homepage();
                }
                else if ($route === 'mairie')
                {
                    require './views/public/mairie/mairie.phtml';
                }
                else if ($route === 'projets')
                {
                    require './views/public/projets/projets.phtml';
                }
                else if ($route === 'pratique')
                {
                    require './views/public/pratique/pratique.phtml';
                }
                else if ($route === 'vivre')
                {
                    require './views/public/vivre/vivre.phtml';
                }
                else if ($route === 'decouvrir')
                {
                    require './views/public/decouvrir/decouvrir.phtml';
                }

                // ADMIN
                else if(str_starts_with($route,'admin'))
                {
                    //check if session user is empty, if yes redirect to login, else check for the rest of the route or call dashboard
                    if (str_contains($route,'comptes-rendus-conseils-municipaux'))
                    {
                        $this->pageController->MunicipalCouncilReports();
                    }
                    else if (str_contains($route,'bulletins-municipaux'))
                    {
                        $this->pageController->MunicipalBulletins();
                    }
                    else if (str_contains($route,'ajouter-un-fichier'))
                    {
                        $this->fileController->uploadFile($_GET['file']);
                    }
                    require './views/admin/dashboard.phtml';//need a render instead to pass into data stuff for dashboard
                }

                // USER
                else if ($route === 'espace-famille')
                {
                    //check is session user empty, if yes then login otherwise load dashboard with user infos
                    require './views/user/dashboard.phtml';//need a render instead to pass into data stuff for dashboard
                }
            }
            // DEFAULT
            else
            {
                  //require './views/layout.phtml';
                  $this->pageController->homepage();
            }

        }

    }

?>