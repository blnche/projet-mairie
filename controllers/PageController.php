<?php
    class PageController extends AbstractController
    {
        private EventManager $eventManager;
        private MunicipalBulletinManager $bulletinManager;
        private MunicipalCouncilReportManager $councilReportManager;
        private ChildManager $childManager;
        private UserManager $userManager;
        private CafeteriaDateManager $cafeteriaDateManager;

        public function __construct()
        {
            $this->eventManager = new EventManager();
            $this->bulletinManager = new MunicipalBulletinManager();
            $this->councilReportManager = new MunicipalCouncilReportManager();
            $this->childManager = new ChildManager();
            $this->userManager = new UserManager();
            $this->cafeteriaDateManager = new CafeteriaDateManager();
        }

        public function events() : array
        {
            $allEvents = $this->eventManager->getAllEvents();
            $futureEvents = $this->eventManager->getFutureEvents();
            $pastEvents = $this->eventManager->getPastEvents();

            return ['all' => $allEvents, 'future' => $futureEvents, 'past' => $pastEvents];
        }
        public function publicHomepage() : void
        {
            $events = $this->events();
            $this->render('views/public/homepage.phtml', ['allEvents' => $this->eventManager->getAllEvents(), 'futureEvents' => $this->eventManager->getFutureEvents(), 'pastEvents' => $this->eventManager->getPastEvents(), 'events' => $events['future']], 'Accueil');
        }
        public function userHomepage() : void
        {
            $this->render('views/user/dashboard.phtml', [], 'User Accueil', 'user');
        }
        public function adminHomepage() : void
        {
            $this->render('views/admin/dashboard.phtml', [], 'Admin Accueil', 'admin');
        }

        public function MunicipalCouncilReports() : void
        {
            $comptes_rendus = $this->councilReportManager->getCouncilReports();

            if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] === 'ROLE_ADMIN' || $_SESSION['user_role'] === 'ROLE_SUPER_ADMIN'))
            {
                $this->render('views/admin/comptes_rendus_cm/comptes-rendus-conseils-municipaux.phtml', ['comptes-rendus' => $comptes_rendus], 'Comptes rendus des conseils municipaux', 'admin');
            }
            else
            {
                $this->render('views/public/mairie/conseil_municipal/comptes_rendus_cm.phtml', ['comptes-rendus' => $comptes_rendus], 'Comptes rendus des conseils municipaux');
            }
        }
        public function MunicipalBulletins() : void
        {
            $bulletins = $this->bulletinManager->getBulletins();

            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'ROLE_ADMIN' || $_SESSION['user_role'] === 'ROLE_SUPER_ADMIN')
            {
                $this->render('views/admin/bulletins_municipaux/bulletins-municipaux.phtml', ['bulletins' => $bulletins], 'Bulletins Municipaux', 'admin');
            }
            else
            {
                $this->render('views/public/mairie/conseil_municipal/bulletins_municipaux.phtml', ['bulletins' => $bulletins], 'Bulletins Municipaux');
            }
        }

        public function Child($id) : void
        {
            $child = $this->childManager->getChildById($id);

            $this->render('views/user/profil_enfant.phtml', ['child'=>$child], $child->getFirstName(), 'user');
        }
        public function Children($id) : void
        {
            $children = $this->childManager->getChildrenByParentId($id);

            $this->render('views/user/enfants.phtml', ['children' => $children], 'Mes enfants', 'user');
        }
        public function AddChild() : void
        {
            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $child = new Child(
                    htmlspecialchars($_POST['firstName']),
                    htmlspecialchars($_POST['lastName']),
                    htmlspecialchars($_POST['age'])
                );
                $child->setParent($this->userManager->getUserById($_SESSION['user_id']));

                $this->childManager->createChild($child);
                header('Location:index.php?route=espace-famille/enfants');
            }
            else
            {
                $this->render('views/user/_add-child.phtml', [], 'Ajouter mon enfant', 'user');
            }
        }

        public function CafeteriaDates() : void
        {
            $dates = $this->cafeteriaDateManager->getCafeteriaDates();
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'ROLE_USER')
            {
                $children = $this->childManager->getChildrenByParentId($_SESSION['user_id']);
                $this->render('views/user/cantine.phtml', ['cafeteria-weeks' => $dates, 'children' => $children], 'Dates de la cantine', 'user');
            }
            else
            {
                $this->render('views/admin/cantine/cantine.phtml', ['cafeteria-weeks' => $dates], 'Dates cantine', 'admin');
            }
        }

        public function NewCafeteriaDates() : void
        {

            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $yearStart = htmlspecialchars($_POST['year-start']);
                $yearEnd = htmlspecialchars($_POST['year-end']);

                $dates = $this->cafeteriaDateManager->getCafeteriaDates();
                $this->render('views/admin/cantine/cantine.phtml', ['cafeteria-weeks' => $dates], 'dates cantine', 'admin');
            }
            else
            {
                $this->render('views/admin/cantine/_form_new-year.phtml', [], 'New year', 'admin');
            }
        }

        public function conseilMunicipal() : void
        {
            $bm = $this->bulletinManager->getBulletins();
            $crcm = $this->councilReportManager->getCouncilReports();

            $this->render('views/public/mairie/conseil_municipal/conseil_municipal.phtml', ['bm' => $bm, 'crcm' => $crcm], 'Conseil Municipal');
        }
        public function townHall() : void
        {
            $this->render('views/public/mairie/mairie.phtml', [], 'Mairie');
        }
    }
?>