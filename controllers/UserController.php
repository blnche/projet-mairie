<?php
//require_once 'AbstractController.php';
    class UserController extends AbstractController
    {
        private UserManager $manager;

        public function __construct()
        {
            $this->manager = new UserManager();
        }

        public function index() : void
        {
            //$this->render('views/public/homepage.phtml', ['users' => $this->manager->getAllUsers()]);
        }

        public function create() : void
        {

        }

        public function read() : void
        {

        }

        public function update() : void
        {

        }

        public function delete() : void
        {

        }
    }
?>