<?php
    class PageController extends AbstractController
    {
        private EventManager $eventManager;
        private MunicipalBulletinManager $bulletinManager;
        private MunicipalCouncilReportManager $councilReportManager;
        private ChildManager $childManager;
        private UserManager $userManager;
        private CafeteriaDateManager $cafeteriaDateManager;
        private AddressManager $addressManager;
        private AssociationManager $associationManager;
        private LocationManager $locationManager;

        public function __construct()
        {
            $this->eventManager = new EventManager();
            $this->bulletinManager = new MunicipalBulletinManager();
            $this->councilReportManager = new MunicipalCouncilReportManager();
            $this->childManager = new ChildManager();
            $this->userManager = new UserManager();
            $this->cafeteriaDateManager = new CafeteriaDateManager();
            $this->addressManager = new AddressManager();
            $this->associationManager = new AssociationManager();
            $this->locationManager = new LocationManager();
        }

        public function events() : array
        {
            $allEvents = $this->eventManager->getAllEvents();
            $futureEvents = $this->eventManager->getFutureEvents();
            $pastEvents = $this->eventManager->getPastEvents();

            return ['all' => $allEvents, 'future' => $futureEvents, 'past' => $pastEvents];
        }
        public function publicHomepage() : void
        {
            $events = $this->events();
            $this->render('views/public/homepage.phtml', ['allEvents' => $this->eventManager->getAllEvents(), 'futureEvents' => $this->eventManager->getFutureEvents(), 'pastEvents' => $this->eventManager->getPastEvents(), 'events' => $events['future']], 'Accueil');
        }
        public function userHomepage() : void
        {
            $this->render('views/user/dashboard.phtml', [], 'User Accueil', 'user');
        }
        public function adminHomepage() : void
        {
            $this->render('views/admin/dashboard.phtml', [], 'Admin Accueil', 'admin');
        }

        public function error404() : void
        {
            $this->render('views/public/error404.phtml', [], 'Error 404');
        }

        public function MunicipalCouncilReports() : void
        {
            $comptes_rendus = $this->councilReportManager->getAllMunicipalCouncilReports();

            if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] === 'ROLE_ADMIN' || $_SESSION['user_role'] === 'ROLE_SUPER_ADMIN'))
            {
                $this->render('views/admin/comptes_rendus_cm/comptes-rendus-conseils-municipaux.phtml', ['comptes-rendus' => $comptes_rendus], 'Comptes rendus des conseils municipaux', 'admin');
            }
            else
            {
                $this->render('views/public/mairie/conseil_municipal/comptes_rendus_cm.phtml', ['comptes-rendus' => $comptes_rendus], 'Comptes rendus des conseils municipaux');
            }
        }
        public function MunicipalBulletins() : void
        {
            $bulletins = $this->bulletinManager->getAllMunicipalBulletins();

            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'ROLE_ADMIN' || $_SESSION['user_role'] === 'ROLE_SUPER_ADMIN')
            {
                $this->render('views/admin/bulletins_municipaux/bulletins-municipaux.phtml', ['bulletins' => $bulletins], 'Bulletins Municipaux', 'admin');
            }
            else
            {
                $this->render('views/public/mairie/conseil_municipal/bulletins_municipaux.phtml', ['bulletins' => $bulletins], 'Bulletins Municipaux');
            }
        }

        public function Child($id) : void
        {
            $child = $this->childManager->getChildById($id);

            $this->render('views/user/profil_enfant.phtml', ['child'=>$child], $child->getFirstName(), 'user');
        }
        public function Children($id) : void
        {
            $children = $this->childManager->getChildrenByParentId($id);

            $this->render('views/user/enfants.phtml', ['children' => $children], 'Mes enfants', 'user');
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
                header('Location:index.php?route=espace-famille/enfants');
            }
            else
            {
                $this->render('views/user/_add-child.phtml', [], 'Ajouter mon enfant', 'user');
            }
        }

        public function CafeteriaDates() : void
        {
            $dates = $this->cafeteriaDateManager->getAllCafeteriaDates();
            //get inscription for children
            //how do i check weeks on cantine for all children ? add a column for each child and if a inscription exist for the week number then say enrolled else not enrolled
            //if a child enroll is ok for a day then say on this day enroll, else to decicde, the week row can have multiple line inside corresponding to each child status on enrollment

            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'ROLE_USER')
            {
                $children = $this->childManager->getChildrenByParentId($_SESSION['user_id']);
                $childrenEnrollments = [];

                foreach($children as $child)
                {
                    $childEnrollments = $this->cafeteriaDateManager->getEnrollmentCafeteriaDatesByChildId($child->getId());
                    $childrenEnrollments[] = $childEnrollments;
                }

                $this->render('views/user/cantine.phtml', ['cafeteria-weeks' => $dates, 'children' => $children, 'childrenEnrollments' => $childrenEnrollments], 'Dates de la cantine', 'user');
            }
            else
            {
                $this->render('views/admin/cantine/cantine.phtml', ['cafeteria-weeks' => $dates], 'Dates cantine', 'admin');
            }
        }

        public function NewCafeteriaDates() : void
        {

            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $yearStart = htmlspecialchars($_POST['year-start']);
                $yearEnd = htmlspecialchars($_POST['year-end']);

                $dates = $this->cafeteriaDateManager->getAllCafeteriaDates();
                $this->render('views/admin/cantine/cantine.phtml', ['cafeteria-weeks' => $dates], 'dates cantine', 'admin');
            }
            else
            {
                $this->render('views/admin/cantine/_form_new-year.phtml', [], 'New year', 'admin');
            }
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
                header('Location:index.php?route=espace-famille/cantine');
            }
            else
            {
                $this->render('views/user/cantine_semaine.phtml', ['week' => $week, 'children' => $children], 'Semaine du '.htmlspecialchars($_GET['semaine']), 'user' );
            }
        }

        public function conseilMunicipal() : void
        {
            $bm = $this->bulletinManager->getAllMunicipalBulletins();
            $crcm = $this->councilReportManager->getAllMunicipalCouncilReports();

            $this->render('views/public/mairie/conseil_municipal/conseil_municipal.phtml', ['bm' => $bm, 'crcm' => $crcm], 'Conseil Municipal');
        }
        public function townHall() : void
        {
            $this->render('views/public/mairie/mairie.phtml', [], 'Mairie');
        }

        public function InformationsLocales() : void
        {
            $this->render('views/admin/informations_locales/dashboard.phtml', [], 'Infos locales', 'admin');
        }

        public function Associations() : void
        {
            $associations = $this->associationManager->getAllAssociations();
            $this->render('views/admin/informations_locales/associations/associations.phtml', ['associations' => $associations], 'Infos locales - associations', 'admin');
        }

        public function AddAssociation() : void
        {
            if(isset($_POST['addAssociation']))
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

                //Create new association
                $name = htmlspecialchars($_POST['name']);
                $presidentFirstname = htmlspecialchars($_POST['presidentFirstname']);
                $presidentLastname = htmlspecialchars($_POST['presidentLastname']);

                $association = new Association(
                    $name,
                    $presidentFirstname,
                    $presidentLastname,
                    'active'
                );
                $association->setAddress($newAddress);
                $this->associationManager->addAssociation($association);

                header('Location:index.php?route=admin/informations-locales/associations');
            }
            else
            {
                $this->render('views/admin/informations_locales/associations/_form-add-associations.phtml', [], 'Infos locales - associations', 'admin');
            }
        }

        public function ModifyAssociation(int $associationId) : void
        {
            if(isset($_POST['modifyAssociation']))
            {
                $associationCurrentInformations = $this->associationManager->getAssociationById($associationId);
                $associationCurrentAddress = $associationCurrentInformations->getAddress();
                //var_dump(!empty($_POST['status']));
                //xdebug_break();

                //check if field for address have been filled and then make a new address object OR if not filled get the infos from previous address
                if (!empty($_POST['address']))
                {
                    $addressString = htmlspecialchars($_POST['address']);
                }
                else {
                    $addressString = $associationCurrentAddress->getAddress();
                }

                if (!empty($_POST['code-postal']))
                {
                    $codePostal = htmlspecialchars($_POST['code-postal']);
                }
                else {
                    $codePostal = $associationCurrentAddress->getCodePostal();
                }

                if (!empty($_POST['ville']))
                {
                    $ville = htmlspecialchars($_POST['ville']);
                }
                else {
                    $ville = $associationCurrentAddress->getCommune();
                }

                $address = new Address(
                    $codePostal,
                    $ville,
                    $addressString
                );
                $address->setId($associationCurrentAddress->getId());

                $addressUpdated = $this->addressManager->editAddress($address);

                if (!empty($_POST['name']))
                {
                    $name = htmlspecialchars($_POST['name']);
                }
                else {
                    $name = $associationCurrentInformations->getName();
                }

                if (!empty($_POST['presidentFirstname']))
                {
                    $presidentFirstname = htmlspecialchars($_POST['presidentFirstname']);
                }
                else {
                    $presidentFirstname = $associationCurrentInformations->getPresidentFirstName();
                }
                if (!empty($_POST['presidentLastname']))
                {
                    $presidentLastname = htmlspecialchars($_POST['presidentLastname']);
                }
                else {
                    $presidentLastname = $associationCurrentInformations->getPresidentLastName();
                }
                if (!empty($_POST['status']))
                {
                    $status = htmlspecialchars($_POST['status']);
                }
                else {
                    $status = $associationCurrentInformations->getStatus();
                }

                $association = new Association(
                    $name,
                    $presidentFirstname,
                    $presidentLastname,
                    $status
                );
                $association->setAddress($addressUpdated);
                $association->setId($associationCurrentInformations->getId());

                $this->associationManager->editAssociation($association);

                header('Location:index.php?route=admin/informations-locales/associations');
            }
            else
            {
                $this->render('views/admin/informations_locales/associations/_form-modify-association.phtml', [], 'Infos locales - associations', 'admin');
            }
        }

        public function ProfessionnelsLocaux() : void
        {
            $this->render('views/admin/informations_locales/professionnels-locaux.phtml', [], 'Infos locales - professionnels-locaux', 'admin');
        }

        public function Lieux() : void
        {
            $locations = $this->locationManager->getAllLocations();
            $this->render('views/admin/informations_locales/locations/lieux.phtml', ['locations' => $locations], 'Infos locales - lieux', 'admin');
        }

        public function AddLocation() : void
        {
            if(isset($_POST['registerLocation']))
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

                //Create new location
                $name = htmlspecialchars($_POST['name']);
                $type = htmlspecialchars($_POST['type']);
                $telephone = htmlspecialchars($_POST['telephone']);
                $description = htmlspecialchars($_POST['description']);

                $location = new Location(
                    $name,
                    $type,
                    $telephone,
                    $description
                );
                $location->setAddress($newAddress);
                $this->locationManager->addLocation($location);

                header('Location:index.php?route=admin/informations-locales/lieux');
            }
            else
            {
                $this->render('views/admin/informations_locales/locations/_form-add-location.phtml', [], 'Infos locales - locations', 'admin');
            }
        }

        public function ModifyLocation(int $locationId) : void
        {
            if(isset($_POST['modifyLocation']))
            {
                $locationCurrentInformations = $this->locationManager->getLocationById($locationId);
                $locationCurrentAddress = $locationCurrentInformations->getAddress();

                //check if field for address have been filled and then make a new address object OR if not filled get the infos from previous address
                if (!empty($_POST['address']))
                {
                    $addressString = htmlspecialchars($_POST['address']);
                }
                else {
                    $addressString = $locationCurrentAddress->getAddress();
                }

                if (!empty($_POST['code-postal']))
                {
                    $codePostal = htmlspecialchars($_POST['code-postal']);
                }
                else {
                    $codePostal = $locationCurrentAddress->getCodePostal();
                }

                if (!empty($_POST['ville']))
                {
                    $ville = htmlspecialchars($_POST['ville']);
                }
                else {
                    $ville = $locationCurrentAddress->getCommune();
                }

                $address = new Address(
                    $codePostal,
                    $ville,
                    $addressString
                );
                $address->setId($locationCurrentAddress->getId());

                $addressUpdated = $this->addressManager->editAddress($address);

                if (!empty($_POST['name']))
                {
                    $name = htmlspecialchars($_POST['name']);
                }
                else {
                    $name = $locationCurrentInformations->getName();
                }

                if (!empty($_POST['type']))
                {
                    $type = htmlspecialchars($_POST['type']);
                }
                else {
                    $type = $locationCurrentInformations->getType();
                }
                if (!empty($_POST['telephone']))
                {
                    $telephone = htmlspecialchars($_POST['telephone']);
                }
                else {
                    $telephone = $locationCurrentInformations->getTelephone();
                }
                if (!empty($_POST['description']))
                {
                    $description = htmlspecialchars($_POST['description']);
                }
                else {
                    $description = $locationCurrentInformations->getDescription();
                }

                $location = new Location(
                    $name,
                    $type,
                    $telephone,
                    $description
                );
                $location->setAddress($addressUpdated);
                $location->setId($locationCurrentInformations->getId());

                $this->locationManager->editLocation($location);

                header('Location:index.php?route=admin/informations-locales/lieux');
            }
            else
            {
                $this->render('views/admin/informations_locales/locations/_form-modify-location.phtml', [], 'Infos locales - locations', 'admin');
            }
        }
    }
?>