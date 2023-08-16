<?php
//require_once 'AbstractController.php';
    class PageController extends AbstractController
    {
        private EventManager $eventManager;
        private MunicipalBulletinManager $bulletinManager;

        public function __construct()
        {
            $this->eventManager = new EventManager();
            $this->bulletinManager = new MunicipalBulletinManager();
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
            $this->render('views/public/homepage.phtml', ['allEvents' => $this->eventManager->getAllEvents(),
                'futureEvents' => $this->eventManager->getFutureEvents(),
                'pastEvents' => $this->eventManager->getPastEvents(),
                'events' => $events['future']]);
        }

        public function MunicipalCouncilReports() : void
        {
            $this->render('views/admin/comptes_rendus_cm/comptes-rendus-conseils-municipaux.phtml', []);
        }
        public function MunicipalBulletins() : void
        {
            $bulletins = $this->bulletinManager->getBulletins();
            $this->render('views/admin/bulletins_municipaux/bulletins-municipaux.phtml', ['bulletins' => $bulletins], 'Bulletins Municipaux', 'admin');
        }
    }
?>