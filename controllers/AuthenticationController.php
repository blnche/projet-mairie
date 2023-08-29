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
                header('Location:/authentification/se-connecter');
            }
            else
            {
                $this->render('views/authentication/register.phtml', [], 'Créer un compte', 'authentication');
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
                if (password_verify($password, $user->getPassword()))
                {
                    //Save user in session
                    $id = $user->getId();
                    $role = $user->getRole();

                    $_SESSION['user_id'] = $id;
                    $_SESSION['user_role'] = $role;

                    //Check role to render corresponding dashboard
                    if ($role === 'ROLE_SUPER_ADMIN' || $role === 'ROLE_ADMIN') {
                        header('Location:/admin');
                    } else if ($role === 'ROLE_USER') {
                        $_SESSION['user_lastName'] = $user->getLastName();

                        header('Location:/espace-famille/'.$_SESSION['user_lastName']);
                    }
                } else {
                    echo "L'un des champs est erroné";
                }
            } else {
                $this->render('views/authentication/login.phtml',[],'Se connecter', 'authentication');
            }
        }

        public function logout() : void
        {
            session_destroy();
            header('Location:/');
        }
    }
?>