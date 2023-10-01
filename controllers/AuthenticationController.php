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
            if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register']))
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
                $firstname = htmlspecialchars($_POST['firstName']);
                $lastname = htmlspecialchars($_POST['lastName']);
                $email = htmlspecialchars($_POST['email']);
                if ($_POST['password'] === $_POST['confirmPassword'])
                {
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }
                $key = htmlspecialchars($_POST['role_key']);

                if ($key === 'admin123azerty') {
                    $role = 'ROLE_ADMIN';
                } else if ($key === 'userazerty123') {
                    $role = 'ROLE_USER';
                } else if ($key === 'superadmin123azerty') {
                    $role = 'ROLE_SUPER_ADMIN';
                }

                $user = new User(
                    $email,
                    $password,
                    $role
                );
                $user->setFirstName($firstname);
                $user->setLastName($lastname);
                $user->setAddress($newAddress);
                $this->userManager->addUser($user);
                
                header('Location:/projet-final/projet-mairie/authentification/se-connecter');
            }
            else
            {
                $this->render('views/authentication/_register-form.phtml', [], 'Créer un compte', 'authentication');
            }
        }
        public function login() : void
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login']))
            {
                //Find user
                $email = htmlspecialchars($_POST['email']);
                $user = $this->userManager->getUserByEmail($email);

                //Check password
                $password = $_POST['password'];
                if ($user !== null && password_verify($password, $user->getPassword()))
                {
                    //Save user in session
                    $id = $user->getId();
                    $role = $user->getRole();
                    $email = $user->getEmail();

                    $_SESSION['user_id'] = $id;
                    $_SESSION['user_role'] = $role;
                    $_SESSION['user_email'] = $email;

                    //Check role to render corresponding dashboard
                    if ($role === 'ROLE_SUPER_ADMIN' || $role === 'ROLE_ADMIN') {
                        header('Location:/projet-final/projet-mairie/admin');
                    } else if ($role === 'ROLE_USER') {
                        $_SESSION['user_lastName'] = $user->getLastName();

                        header('Location:/projet-final/projet-mairie/espace-famille/'.$_SESSION['user_lastName']);
                    }
                } else {
                    echo "L'un des champs est erroné";
                    $this->render('views/authentication/_login-form.phtml',[],'Se connecter', 'authentication');
                }
            } else {
                $this->render('views/authentication/_login-form.phtml',[],'Se connecter', 'authentication');
            }
        }

        public function logout() : void
        {
            session_destroy();
            header('Location:/projet-final/projet-mairie/');
        }
    }
?>