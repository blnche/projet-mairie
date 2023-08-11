<?php 

    class Router {
        private UserController $userController;
        private PageController $pageController;
        private FileController $fileController;

        /**
         * @param UserController $userController
         * @param PageController $pageController
         * @param FileController $fileController
         */
        public function __construct()
        {
            $this->userController = new UserController();
            $this->pageController = new PageController();
            $this->fileController = new FileController();
        }

        public function checkRoute() : void
        {
            if (isset($_GET['route']))
            {
                $route = $_GET['route'];
                if($route === 'back-office')
                {
                    require './views/admin/dashboard.phtml';
                }
                else if ($route === 'comptes-rendus-conseils-municipaux')
                {
                    $this->pageController->MunicipalCouncilReports();
                }
                else if ($route === 'bulletins-municipaux')
                {
                    $this->pageController->MunicipalBulletins();
                }
                else if ($route === 'ajouter-un-fichier')
                {
                    var_dump($_GET['file']);
                    $this->fileController->uploadFile($_GET['file']);
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
                else if ($route === 'espace-famille')
                {
                    require './views/user/dashboard.phtml';
                }
            }
            else
            {
        //        require './views/layout.phtml';
                  $this->pageController->homepage();
            }

        }

    }

?>