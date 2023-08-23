<?php
    class AuthenticationController extends AbstractController
    {
        private UserManager $userManager;
        private AddressManager $addressManager;

        public function __construct()
        {
            $this->userManager = new UserManager();
            $this->addressManager = new AddressManager();
        }

        public function register() : void
        {
            if(isset($_POST['register']))
            {
                //Create new address
                $addressString = htmlspecialchars($_POST['address']);
                $codePostal = htmlspecialchars($_POST['code-postal']);
                $ville = htmlspecialchars($_POST['ville']);

                $address = new Address(
                    $codePostal,
                    $ville,
                    $addressString
                );
                $newAddress = $this->addressManager->addAddress($address);

                //Create new user
                $email = htmlspecialchars($_POST['email']);
                if ($_POST['password'] === $_POST['confirmPassword'])
                {
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }
                $role = htmlspecialchars($_POST['role']);

                $user = new User(
                    $email,
                    $password,
                    $role
                );
                $user->setAddress($newAddress);
                $this->userManager->addUser($user);
                header('Location:index.php?route=login');
            }
            else
            {
                $this->render('views/authentication/register.phtml', [], 'Créer un compte', 'authentication');
            }
        }
        public function login() : void
        {
            if (isset($_POST['login']))
            {
                //Find user
                $email = htmlspecialchars($_POST['email']);
                $user = $this->userManager->getUserByEmail($email);

                //Check password
                $password = $_POST['password'];
                if (password_verify($password, $user->getPassword()))
                {
                    //Save user in session
                    $id = $user->getId();
                    $role = $user->getRole();

                    $_SESSION['user_id'] = $id;
                    $_SESSION['user_role'] = $role;

                    //Check role to render corresponding dashboard
                    if ($role === 'ROLE_SUPER_ADMIN' || $role === 'ROLE_ADMIN')
                    {
                        //$this->render('views/admin/dashboard.phtml',['user' => $user],'Tableau de bord Admin', 'admin');
                        header('Location:index.php?route=admin');
                    }
                    else if ($role === 'ROLE_USER')
                    {
                        //$this->render('views/user/dashboard.phtml',[],'Tableau de bord de', 'user');
                        header('Location:index.php?route=espace-famille');
                    }
                }
                else
                {
                    echo "L'adresse mail ou le mot de passe est erroné";
                }




                //when we need to echo lastname user or in the route have their name too, we can retrieve user infos in methods of controller rendering the page called

            }
            else
            {
                $this->render('views/authentication/login.phtml',[],'Se connecter', 'authentication');
            }
        }

        public function logout() : void
        {
            session_destroy();
            header('Location:index.php?route=accueil');
        }
    }
?>