<?php
    class UserController extends AbstractController
    {
        private UserManager $userManager;
        private ChildManager $childManager;

        public function __construct()
        {
            $this->$userManager = new UserManager();
            $this->childManager = new ChildManager();
        }

        public function index() : void
        {
            //$this->render('views/public/homepage.phtml', ['users' => $this->manager->getAllUsers()]);
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
                header('Location:/espace-famille/enfants');
            }
            else
            {
                $this->render('views/user/_add-child.phtml', [], 'Ajouter mon enfant', 'user');
            }
        }

        // CAFETERIA

    }
?>