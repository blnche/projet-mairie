<?php
    class UserController extends AbstractController
    {
        private UserManager $userManager;
        private ChildManager $childManager;
        private CafeteriaDateManager $cafeteriaDateManager;
        private AddressManager $addressManager;

        public function __construct()
        {
            $this->userManager = new UserManager();
            $this->childManager = new ChildManager();
            $this->cafeteriaDateManager = new CafeteriaDateManager();
            $this->addressManager = new AddressManager();
        }

        public function index() : void
        {
            //$this->render('views/public/homepage.phtml', ['users' => $this->manager->getAllUsers()]);
        }
        public function readUser() : void
        {

        }
        public function updateUser() : void
        {
            if(isset($_POST['modifyUser'])) {
                $userCurrentInformations = $this->userManager->getUserById($_SESSION['user_id']);
                $userCurrentAddress = $userCurrentInformations->getAddress();

                //Check address changes
                if (!empty($_POST['address']))
                {
                    $addressString = htmlspecialchars($_POST['address']);
                }
                else {
                    $addressString = $userCurrentAddress->getAddress();
                }

                if (!empty($_POST['code-postal']))
                {
                    $codePostal = htmlspecialchars($_POST['code-postal']);
                }
                else {
                    $codePostal = $userCurrentAddress->getCodePostal();
                }

                if (!empty($_POST['ville']))
                {
                    $ville = htmlspecialchars($_POST['ville']);
                }
                else {
                    $ville = $userCurrentAddress->getCommune();
                }

                $address = new Address(
                    $codePostal,
                    $ville,
                    $addressString
                );
                $address->setId($userCurrentAddress->getId());

                $addressUpdated = $this->addressManager->editAddress($address);

                //Check user changes
                if(isset($_POST['email']))
                {
                    $email = htmlspecialchars($_POST['email']);
                } else {
                    $email = $userCurrentInformations->getEmail();
                }

                if(isset($_POST['password']))
                {
                    if ($_POST['password'] === $_POST['confirmPassword'])
                    {
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    }
                    else {
                        echo 'Erreur';
                    }
                } else {
                    $password = $userCurrentInformations->getPassword();
                }

                if(isset($_POST['firstName']))
                {
                    $firstName = htmlspecialchars($_POST['firstName']);
                } else {
                    $firstName = $userCurrentInformations->getFirstName();
                }

                if(isset($_POST['lastName']))
                {
                    $lastName = htmlspecialchars($_POST['lastName']);
                } else {
                    $lastName = $userCurrentInformations->getLastName();
                }

                $user = new User (
                    $email,
                    $password,
                    $userCurrentInformations->getRole()
                );
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setAddress($addressUpdated);
                $user->setId($userCurrentInformations->getId());

                $this->userManager->editUser($user);

                header('Location:/espace-famille/');
            }
            else {
                $this->render('views/user/_form-modifify-user.phtml', [], 'Modifier vos informations');
            }
        }
        public function deleteUser() : void
        {

        }

        // DASHBOARD
        public function userHomepage() : void
        {
            $this->render('views/user/dashboard.phtml', [], 'User Accueil', 'user');
        }
        public function Children($id) : void
        {
            $children = $this->childManager->getChildrenByParentId($id);

            $this->render('views/user/enfants.phtml', ['children' => $children], 'Mes enfants', 'user');
        }

        // CHILD
        public function Child($id) : void
        {
            $child = $this->childManager->getChildById($id);

            $this->render('views/user/profil_enfant.phtml', ['child'=>$child], $child->getFirstName(), 'user');
        }
        public function AddChild() : void
        {
            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $child = new Child(
                    htmlspecialchars($_POST['firstName']),
                    htmlspecialchars($_POST['lastName']),
                    htmlspecialchars($_POST['age'])
                );
                $child->setParent($this->userManager->getUserById($_SESSION['user_id']));

                $this->childManager->addChild($child);
                header('Location:/espace-famille/<?= $user->getLastName ?>/enfants');
            }
            else
            {
                $this->render('views/user/_add-child.phtml', [], 'Ajouter mon enfant', 'user');
            }
        }

        // CAFETERIA
        public function CafeteriaDates() : void
        {
            $dates = $this->cafeteriaDateManager->getAllCafeteriaDates();
            //get inscription for children
            //how do i check weeks on cantine for all children ? add a column for each child and if a inscription exist for the week number then say enrolled else not enrolled
            //if a child enroll is ok for a day then say on this day enroll, else to decicde, the week row can have multiple line inside corresponding to each child status on enrollment

            $children = $this->childManager->getChildrenByParentId($_SESSION['user_id']);
            $childrenEnrollments = [];

            foreach($children as $child)
            {
                $childEnrollments = $this->cafeteriaDateManager->getEnrollmentCafeteriaDatesByChildId($child->getId());
                $childrenEnrollments[] = $childEnrollments;
            }

            $this->render('views/user/cantine.phtml', ['cafeteria-weeks' => $dates, 'children' => $children, 'childrenEnrollments' => $childrenEnrollments], 'Dates de la cantine', 'user');
        }
        public function CafeteriaEnrollment() : void
        {
            $week = $this->cafeteriaDateManager->getCafeteriaDateByWeekNumber(htmlspecialchars($_GET['semaine']));
            $children = $this->childManager->getChildrenByParentId($_SESSION['user_id']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $child = $this->childManager->getChildById(htmlspecialchars($_POST['enfant']));
                $days = [
                    'monday' => isset($_POST['monday']) ? htmlspecialchars($_POST['monday']) : 'No',
                    'tuesday' => isset($_POST['tuesday']) ? htmlspecialchars($_POST['tuesday']) : 'No',
                    'wednesday' => isset($_POST['wednesday']) ? htmlspecialchars($_POST['wednesday']) : 'No',
                    'thursday' => isset($_POST['thursday']) ? htmlspecialchars($_POST['thursday']) : 'No',
                    'friday' => isset($_POST['friday']) ? htmlspecialchars($_POST['friday']) : 'No'
                ];
                foreach ($days as $day)
                {
                    if($day === '')
                    {
                        $day = 'No';
                    }
                }
                $this->cafeteriaDateManager->EnrollChildCafeteria($week, $child, $days);
                header('Location:/espace-famille/<?= $user->getLastName ?>/cantine');
            }
            else
            {
                $this->render('views/user/cantine_semaine.phtml', ['week' => $week, 'children' => $children], 'Semaine du '.htmlspecialchars($_GET['semaine']), 'user' );
            }
        }
    }
?>