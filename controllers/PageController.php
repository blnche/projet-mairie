<?php
    class PageController extends AbstractController
    {
        private EventManager $eventManager;
        private MunicipalBulletinManager $bulletinManager;
        private MunicipalCouncilReportManager $councilReportManager;
        private ChildManager $childManager;

        public function __construct()
        {
            $this->eventManager = new EventManager();
            $this->bulletinManager = new MunicipalBulletinManager();
            $this->councilReportManager = new MunicipalCouncilReportManager();
            $this->childManager = new ChildManager();
        }

        public function events() : array
        {
            $allEvents = $this->eventManager->getAllEvents();
            $futureEvents = $this->eventManager->getFutureEvents();
            $pastEvents = $this->eventManager->getPastEvents();

            return ['all' => $allEvents, 'future' => $futureEvents, 'past' => $pastEvents];
        }
        public function homepage() : void
        {
            $events = $this->events();
            $this->render('views/public/homepage.phtml', ['allEvents' => $this->eventManager->getAllEvents(), 'futureEvents' => $this->eventManager->getFutureEvents(), 'pastEvents' => $this->eventManager->getPastEvents(), 'events' => $events['future']], 'Accueil');
        }

        public function MunicipalCouncilReports() : void
        {
            $comptes_rendus = $this->councilReportManager->getCouncilReports();

            if ($_SESSION['user_role'] === 'ROLE_ADMIN' || $_SESSION['user_role'] === 'ROLE_SUPER_ADMIN')
            {
                $this->render('views/admin/comptes_rendus_cm/comptes-rendus-conseils-municipaux.phtml', ['comptes-rendus' => $comptes_rendus], 'Comptes rendus des conseils municipaux', 'admin');
            }
            else
            {
                $this->render('views/admin/comptes_rendus_cm/comptes-rendus-conseils-municipaux.phtml', ['comptes-rendus' => $comptes_rendus], 'Comptes rendus des conseils municipaux');
            }
        }
        public function MunicipalBulletins() : void
        {
            $bulletins = $this->bulletinManager->getBulletins();

            if ($_SESSION['user_role'] === 'ROLE_ADMIN' || $_SESSION['user_role'] === 'ROLE_SUPER_ADMIN')
            {
                $this->render('views/admin/bulletins_municipaux/bulletins-municipaux.phtml', ['bulletins' => $bulletins], 'Bulletins Municipaux', 'admin');
            }
            else
            {
                $this->render('views/admin/bulletins_municipaux/bulletins-municipaux.phtml', ['bulletins' => $bulletins], 'Bulletins Municipaux');
            }
        }

        public function Child($id) : void
        {
            $child = $this->childManager->getChildById($id);

            $this->render('views/user/profil_enfant.phtml', ['child'=>$child], $child->getFirstName(), 'user');
        }
    }
?>