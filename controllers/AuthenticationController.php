<?php
    class AuthenticationController extends AbstractController
    {
        private UserManager $manager;

        public function __construct()
        {
            $this->manager = new UserManager();
        }

        public function login() : void
        {
            $this->renderAdmin('views/authentication/login.phtml',[]);
        }
    }
?>