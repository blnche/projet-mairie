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
            $routeAndParams['subRoute'] = null;
            $routeAndParams['admin'] = null;
            $routeAndParams['familySpace'] = null;
            $routeAndParams['authentication'] = null;
            $routeAndParams['action'] = null;

            $routeAndParams['user'] = null;
            $routeAndParams['child'] = null;
            $routeAndParams['week'] = null;

            $routeAndParams['councilReportSlug'] = null;
            $routeAndParams['bulletinSlug'] = null;
            $routeAndParams['projectSlug'] = null;
            $routeAndParams['postSlug'] = null;
            $routeAndParams['associationSlug'] = null;
            $routeAndParams['locationSlug'] = null;
            $routeAndParams['localProfessionalSlug'] = null;

            if(strlen($route) > 0)
            {
                $tab = explode("/", $route);

                if ($tab[0] === 'authentification')
                {
                    $routeAndParams['route'] = $tab[0];

                    if(isset($tab[1]))
                    {
                        if($tab[1] === 'se-connecter')
                        {
                            $routeAndParams['authentication'] = $tab[1];
                        }
                        else if ($tab[1] === 'se-deconnecter')
                        {
                            $routeAndParams['authentication'] = $tab[1];
                        }
                        else if ($tab[1] === 'enregistrer-nouveau-compte')
                        {
                            $routeAndParams['authentication'] = $tab[1];
                        }
                    }
                }
                else if($tab[0] === 'admin')
                {
                    $routeAndParams['route'] = 'admin';

                    if(isset($tab[1]))
                    {
                        if ($tab[1] === 'modifier-email')
                        {
                            $routeAndParams['admin'] = $tab[1];
                        }
                        else if ($tab[1] === 'ajouter-fichier')
                        {
                            $routeAndParams['admin'] = $tab[1];
                        }
                        else if ($tab[1] === 'bulletins-municipaux')
                        {
                            $routeAndParams['admin'] = $tab[1];

                            if(isset($tab[2]))
                            {
                                $routeAndParams['bulletinSlug'] = $tab[2];
                            }
                        }
                        else if ($tab[1] === 'comptes-rendus-conseil-municipaux')
                        {
                            $routeAndParams['admin'] = $tab[1];

                            if(isset($tab[2]))
                            {
                                $routeAndParams['councilReportSlug'] = $tab[2];
                            }
                        }
                        else if($tab[1] === 'informations-locales')
                        {
                            $routeAndParams['admin'] = $tab[1];

                            if(isset($tab[2]))
                            {
                                if($tab[2] === 'associations')
                                {
                                    $routeAndParams['subRoute'] = $tab[2];

                                    if(isset($tab[3]))
                                    {
                                        if ($tab[3] === 'ajouter')
                                        {
                                            $routeAndParams['route'] = $tab[3];
                                        }
                                        else if ($tab[3] === 'modifier')
                                        {
                                            $routeAndParams['route'] = $tab[3];
                                            $routeAndParams['associationSlug'] = $tab[4];
                                        }
                                    }
                                }
                                else if ($tab[2] === 'lieux')
                                {
                                    $routeAndParams['subRoute'] = $tab[2];

                                    if(isset($tab[3]))
                                    {
                                        if ($tab[3] === 'ajouter')
                                        {
                                            $routeAndParams['route'] = $tab[3];
                                        }
                                        else if ($tab[3] === 'modifier')
                                        {
                                            $routeAndParams['route'] = $tab[3];
                                            $routeAndParams['locationSlug'] = $tab[4];
                                        }
                                    }
                                }
                                else if ($tab[2] === 'professionnels-locaux')
                                {
                                    $routeAndParams['subRoute'] = $tab[2];

                                    if(isset($tab[3]))
                                    {
                                        if ($tab[3] === 'ajouter')
                                        {
                                            $routeAndParams['route'] = $tab[3];
                                        }
                                        else if ($tab[3] === 'modifier')
                                        {
                                            $routeAndParams['route'] = $tab[3];
                                            $routeAndParams['localProfessionalSlug'] = $tab[4];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                else if ($tab[0] === 'espace-famille')
                {
                    $routeAndParams['route'] = $tab[0];
                    $routeAndParams['user'] = $tab[1];

                    if(isset($tab[2]))
                    {
                        if ($tab[2] === 'enfants')
                        {
                            $routeAndParams['familySpace'] = $tab[2];

                            if(isset($tab[3]))
                            {
                                if ($tab[3] === 'ajouter')
                                {
                                    $routeAndParams['action'] = $tab[3];
                                }
                                else if ($tab[3] === 'modifier')
                                {
                                    $routeAndParams['action'] = $tab[3];
                                    $routeAndParams['child'] = $tab[4];
                                }
                                else {
                                    $routeAndParams['child'] = $tab[3];
                                }
                            }
                        }
                        else if ($tab[2] === 'cantine')
                        {
                            $routeAndParams['familySpace'] = $tab[2];

                            if(isset($tab[3]))
                            {
                                if ($tab[3] === 'inscrire')
                                {
                                    $routeAndParams['action'] = $tab[3];
                                    $routeAndParams['week'] = $tab[4];
                                }
                                else if ($tab[3] === 'modifier')
                                {
                                    $routeAndParams['action'] = $tab[3];
                                    $routeAndParams['week'] = $tab[4];
                                }
                            }
                        }
                    }
                }
                else if ($tab[0] === 'mairie')
                {
                    $routeAndParams['route'] = $tab[0];

                    if (isset($tab[1]))
                    {
                        if ($tab[1] === 'conseil-municipal')
                        {
                            $routeAndParams['subRoute'] = $tab[1];

                            if (isset($tab[2]))
                            {
                                if ($tab[2] === 'comptes-rendus-conseil-municipaux')
                                {
                                    $routeAndParams[''] = $tab[2];

                                    if (isset($tab[3]))
                                    {
                                        $routeAndParams['councilReportSlug'] = $tab[3];
                                    }
                                }
                                else if ($tab[2] === 'bulletins-municipaux')
                                {
                                    $routeAndParams[''] = $tab[2];

                                    if (isset($tab[3]))
                                    {
                                        $routeAndParams['bulletinSlug'] = $tab[3];
                                    }
                                }
                            }
                        }
                        else if ($tab[1] === 'services-municipaux')
                        {
                            $routeAndParams['subRoute'] = $tab[1];
                        }
                    }
                }
                else if ($tab[0]  === 'projets')
                {
                    $routeAndParams['route'] = $tab[0];

                    if (isset($tab[1]))
                    {
                        $routeAndParams['projectSlug'] = $tab[1];
                    }
                }
                else if ($tab[0]  === 'pratique')
                {
                    $routeAndParams['route'] = $tab[0];
                    if (isset($tab[1]))
                    {
                        $routeAndParams['postSlug'] = $tab[1];
                    }
                }
                else if ($tab[0]  === 'vivre')
                {
                    $routeAndParams['route'] = $tab[0];
                    if (isset($tab[1]))
                    {
                        $routeAndParams['postSlug'] = $tab[1];
                    }
                }
                else if ($tab[0]  === 'decouvrir')
                {
                    $routeAndParams['route'] = $tab[0];
                    if (isset($tab[1]))
                    {
                        $routeAndParams['postSlug'] = $tab[1];
                    }
                }
                else if ($tab[0]  === 'mention-legales')
                {
                    $routeAndParams['route'] = $tab[0];
                }
                else if ($tab[0]  === 'politique-confidentialité')
                {
                    $routeAndParams['route'] = $tab[0];
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
            if($routeTab['route'] === 'authentification')
            {
                if ($routeTab['authentication'] === 'enregistrer-nouveau-compte')
                {
                    $this->authenticationController->register();
                }
                else if ($routeTab['authentication'] === 'se-connecter')
                {
                    $this->authenticationController->login();
                }
                else if ($routeTab['authentication'] === 'se-deconnecter')
                {
                    $this->authenticationController->logout();
                }
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
                    if ($routeTab['admin'] === 'modifier-email')
                    {
                        //user modifier email
                    }
                    else if ($routeTab['admin'] === 'ajouter-un-fichier')
                    {
                        $this->fileController->uploadFile($_GET['file']);
                    }
                    else if ($routeTab['admin'] === 'bulletins-municipaux')
                    {
                        $this->pageController->MunicipalBulletins();

                        if(isset($routeTab['bulletinSlug']))
                        {
                            //show bulletin in pdf
                        }
                    }
                    else if ($routeTab['admin'] === 'comptes-rendus-conseils-municipaux')
                    {
                        $this->pageController->MunicipalCouncilReports();

                        if(isset($routeTab['councilReportSlug']))
                        {
                            //show councilreport in pdf
                        }
                    }
                    else if ($routeTab['admin'] === 'informations-locales')
                    {
                        if ($routeTab['subRoute'] === 'associations')
                        {
                            if ($routeTab['action'] === 'ajouter')
                            {
                                $this->pageController->AddAssociation();
                            }
                            else if ($routeTab['action'] === 'modifier')
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