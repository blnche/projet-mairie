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
                    $this->pageController->publicHomepage();
                }
                else if (str_starts_with($route, 'mairie'))
                {
                    if (str_contains($route, 'conseil-municipal'))
                    {
                        if (str_contains($route, 'crcm'))
                        {
                            $this->pageController->MunicipalCouncilReports();
                        }
                        else if (str_contains($route, 'bm'))
                        {
                            $this->pageController->MunicipalBulletins();
                        }
                        else
                        {
                            $this->pageController->conseilMunicipal();
                        }
                    }
                    else if (str_contains($route, 'services-municipaux'))
                    {
                        $this->pageController->SM();
                    }
                    else
                    {
                        $this->pageController->townHall();
                    }
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
                    if (isset($_SESSION['user_id']) && (($_SESSION['user_role'] === 'ROLE_ADMIN') || ($_SESSION['user_role'] === 'ROLE_SUPER_ADMIN')))
                    {
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
                        else
                        {
                            $this->pageController->adminHomepage();
                            //require './views/admin/dashboard.phtml';//need a render instead to pass into data stuff for dashboard
                        }
                    }
                    else
                    {
                        header('Location:index.php?route=login');
                    }
                }

                // USER
                else if (str_starts_with($route,'espace-famille'))
                {
                    //check is session user empty, if yes then login otherwise load dashboard with user infos
                    if (isset($_SESSION['user_id']) && ($_SESSION['user_role'] === 'ROLE_USER'))
                    {
                        if (str_contains($route, 'enfants'))
                        {
                            $this->pageController->Children($_SESSION['user_id']);
                        }
                        else if (str_contains($route, 'consulter-enfant'))
                        {
                            $this->pageController->Child($_GET['enfantId']);
                        }
                        else if (str_contains($route, 'modifier-enfant'))
                        {
                            $this->pageController->ModifyChild($_GET['enfantId']);
                        }
                        else if (str_contains($route, 'ajouter-enfant'))
                        {
                            $this->pageController->AddChild();
                        }
                        else if (str_contains($route, 'cantine'))
                        {
                            $this->pageController->CafeteriaDates();
                        }
                        else
                        {
                            $this->pageController->userHomepage();
                            //require './views/user/dashboard.phtml';//need a render instead to pass into data stuff for dashboard
                        }
                    }
                    else
                    {
                        header('Location:index.php?route=login');
                    }
                }
            }
            // DEFAULT
            else
            {
                  //require './views/layout.phtml';
                  $this->pageController->publicHomepage();
            }

        }

    }

?>