<?php
require_once 'AbstractController.php';
    class PageController extends AbstractController
    {
        private EventManager $eventManager;

        public function __construct()
        {

            $this->eventManager = new EventManager();
        }

        public function homepage() : void
        {
            $this->render('views/public/homepage.phtml', ['events' => $this->eventManager->getAllEvents()]);
        }
    }
?>