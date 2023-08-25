<?php 
    class Router2 {
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

        private function splitRouteAndParameters(string $route) : array
        {
            $routeAndParams = [];
            $routeAndParams['route'] = null;
            $routeAndParams['espace-famille'] = null;
            $routeAndParams['admin'] = null;
            $routeAndParams['subRoute'] = null;
            $routeAndParams['compte-rendu'] = null;
            $routeAndParams['bulletin'] = null;
            $routeAndParams['projet'] = null;
            $routeAndParams['article'] = null;
            $routeAndParams['association'] = null;
            $routeAndParams['lieu'] = null;
            $routeAndParams['professionnel-local'] = null;
            $routeAndParams['utilisateur'] = null;
            $routeAndParams['enfant'] = null;
            $routeAndParams['semaine'] = null;

            if(strlen($route) > 0) // si la chaine de la route n'est pas vide (donc si ça n'est pas la home)
            {
                $tab = explode("/", $route);

                if($tab[0] === 'admin')
                {
                    $routeAndParams['route'] = 'admin';

                    if(isset($tab[1]) && $tab[1] === 'informations-locales')
                    {
                        $routeAndParams['admin'] = $tab[1];
                    }
                }
            }
            else
            {
                $routeAndParams['route'] = '';
            }

            return $routeAndParams;
        }

        public function checkRoute($route) : void
        {
            $routeTab = $this->splitRouteAndParameters($route);

            // AUTHENTICATION
            if (str_contains($route, 'register'))
            {
                $this->authenticationController->register();
            }
            else if (str_contains($route,'login'))
            {
                $this->authenticationController->login();
            }
            else if (str_contains($route, 'logout'))
            {
                $this->authenticationController->logout();
            }

            // PUBLIC
            else if ($routeTab['route'] === 'accueil' || $routeTab['route'] === '')
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
            else if($routeTab['route'] === 'admin')
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
                    else if ($routeTab['admin'] === 'informations-locales')
                    {
                        if (str_contains($route, 'associations'))
                        {
                            if (str_contains($route, 'ajouter'))
                            {
                                $this->pageController->AddAssociation();
                            }
                            else if (str_contains($route, 'modifier'))
                            {
                                var_dump($_GET['associationId']);
                                $this->pageController->ModifyAssociation(htmlspecialchars($_GET['associationId']));
                            }
                            else
                            {
                                $this->pageController->Associations();
                            }
                        }
                        else if (str_contains($route, 'professionnels-locaux'))
                        {
                            $this->pageController->ProfessionnelsLocaux();
                        }
                        else if (str_contains($route, 'lieux'))
                        {
                            $this->pageController->Lieux();
                        }
                        else
                        {
                            $this->pageController->InformationsLocales();
                        }
                    }
                    else if (str_contains($route, 'cantine'))
                    {
                        if (str_contains($route, 'nouvelle-annee'))
                        {
                            $this->pageController->NewCafeteriaDates();
                        }
                        else
                        {
                            $this->pageController->CafeteriaDates();
                        }
                    }
                    else
                    {
                        $this->pageController->adminHomepage();
                        //require './views/admin/dashboard.phtml';//need a render instead to pass into data stuff for dashboard
                    }
                }
                else
                {
                    header('Location:index.php?route=admin/login');
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
                        if (str_contains($route, 'modifier-semaine'))
                        {
                            $this->pageController->CafeteriaEnrollment();
                        }
                        else
                        {
                            $this->pageController->CafeteriaDates();
                        }
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

            // ERROR
            else
            {
                $this->pageController->error404(); //rendered on public layout, is that good or should i keep it as a echo ?
            }

        }

    }

?>