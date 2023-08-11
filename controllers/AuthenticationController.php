<?php
    class AuthenticationController extends AbstractController
    {
        private UserManager $manager;

        public function __construct()
        {
            $this->manager = new UserManager();
        }

        public function register() : void
        {

        }
        public function login() : void
        {
            if ('isset')
            {
                //load user and store it into session
                $_SESSION['user_id'] = '';
                $_SESSION['user_role'] = '';
                //render either user or admin dashboard depending on role of user login
                //when we need to echo lastname user or in the route have their name too, we can retrieve user infos in methods of controller rendering the page called
            }
            else
            {
                $this->render('views/authentication/login.phtml',[]);
            }
        }

        public function logout() : void
        {
            session_destroy();
            header('Location:index.php?route=accueil');
        }
    }
?>