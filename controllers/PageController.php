<?php
require_once 'AbstractController.php';
    class PageController extends AbstractController
    {
        private EventManager $eventManager;

        public function __construct()
        {

            $this->eventManager = new EventManager();
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
    }
?>