<?php
class AdminController extends AbstractController
{
    private EventManager $eventManager;
    private MunicipalCouncilReportManager $councilReportManager;
    private MunicipalBulletinManager $bulletinManager;
    private CafeteriaDateManager $cafeteriaDateManager;
    private AddressManager $addressManager;
    private AssociationManager $associationManager;
    private LocationManager $locationManager;
    private LocalProfessionalManager $localProfessionalManager;

    public function __construct()
    {
        $this->eventManager = new EventManager();
        $this->bulletinManager = new MunicipalBulletinManager();
        $this->councilReportManager = new MunicipalCouncilReportManager();
        $this->cafeteriaDateManager = new CafeteriaDateManager();
        $this->addressManager = new AddressManager();
        $this->associationManager = new AssociationManager();
        $this->locationManager = new LocationManager();
        $this->localProfessionalManager = new LocalProfessionalManager();
    }

    public function events() : array
    {
        $allEvents = $this->eventManager->getAllEvents();
        $futureEvents = $this->eventManager->getFutureEvents();
        $pastEvents = $this->eventManager->getPastEvents();

        return ['all' => $allEvents, 'future' => $futureEvents, 'past' => $pastEvents];
    }

    // DASHBOARD
    public function adminHomepage() : void
    {
        $this->render('views/admin/dashboard.phtml', [], 'Admin Accueil', 'admin');
    }

    // TOWN COUNCIL
    public function municipalCouncilReports() : void
    {
        $comptes_rendus = $this->councilReportManager->getAllMunicipalCouncilReports();

        $this->render('views/admin/comptes_rendus_cm/comptes-rendus-conseils-municipaux.phtml', ['comptes-rendus' => $comptes_rendus], 'Comptes rendus des conseils municipaux', 'admin');
    }
    public function municipalBulletins() : void
    {
        $bulletins = $this->bulletinManager->getAllMunicipalBulletins();

        $this->render('views/admin/bulletins_municipaux/bulletins-municipaux.phtml', ['bulletins' => $bulletins], 'Bulletins Municipaux', 'admin');
    }

    // LOCAL INFORMATION
    public function localInformation() : void
    {
        $this->render('views/admin/informations_locales/dashboard.phtml', [], 'Infos locales', 'admin');
    }

    /// ASSOCIATIONS
    public function associations() : void
    {
        $associations = $this->associationManager->getAllAssociations();
        $this->render('views/admin/informations_locales/associations/associations.phtml', ['associations' => $associations], 'Infos locales - associations', 'admin');
    }
    public function addAssociation() : void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addAssociation']))
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

            header('Location:/admin/informations-locales/associations');
        }
        else
        {
            $this->render('views/admin/informations_locales/associations/_form-add-associations.phtml', [], 'Infos locales - associations', 'admin');
        }
    }
    public function modifyAssociation(int $associationId) : void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifyAssociation']))
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

            header('Location:/admin/informations-locales/associations');
        }
        else
        {
            $this->render('views/admin/informations_locales/associations/_form-modify-association.phtml', [], 'Infos locales - associations', 'admin');
        }
    }

    /// LOCAL PROFESSIONALS
    public function localProfessionals() : void
    {
        $localProfessionals = $this->localProfessionalManager->getAllLocalProfessionals();
        $this->render('views/admin/informations_locales/local-professionals/professionnels-locaux.phtml', ['local-professionals' => $localProfessionals], 'Infos locales - professionnels-locaux', 'admin');
    }
    public function addLocalProfessional() : void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerLocalProfessional']))
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

            //Create new local professional
            $name = htmlspecialchars($_POST['name']);
            $sector = htmlspecialchars($_POST['sector']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $lastname = htmlspecialchars($_POST['lastname']);

            $localProfessional = new LocalProfessional(
                $name,
                $sector,
                $firstname,
                $lastname
            );
            $localProfessional->setAddress($newAddress);
            $this->localProfessionalManager->addLocalProfessional($localProfessional);

            header('Location:/admin/informations-locales/professionnels-locaux');
        }
        else
        {
            $this->render('views/admin/informations_locales/local-professionals/_form-add-local-professional.phtml', [], 'Infos locales - professionnels-locaux', 'admin');
        }
    }
    public function modifyLocalProfessional(int $localProfessionalId) : void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifyLocalProfessional']))
        {
            $localProfessionalCurrentInformations = $this->localProfessionalManager->getLocalProfessionalById($localProfessionalId);
            $localProfessionalCurrentAddress = $localProfessionalCurrentInformations->getAddress();

            //check if field for address have been filled and then make a new address object OR if not filled get the infos from previous address
            if (!empty($_POST['address']))
            {
                $addressString = htmlspecialchars($_POST['address']);
            }
            else {
                $addressString = $localProfessionalCurrentAddress->getAddress();
            }

            if (!empty($_POST['code-postal']))
            {
                $codePostal = htmlspecialchars($_POST['code-postal']);
            }
            else {
                $codePostal = $localProfessionalCurrentAddress->getCodePostal();
            }

            if (!empty($_POST['ville']))
            {
                $ville = htmlspecialchars($_POST['ville']);
            }
            else {
                $ville = $localProfessionalCurrentAddress->getCommune();
            }

            $address = new Address(
                $codePostal,
                $ville,
                $addressString
            );
            $address->setId($localProfessionalCurrentAddress->getId());

            $addressUpdated = $this->addressManager->editAddress($address);

            if (!empty($_POST['name']))
            {
                $name = htmlspecialchars($_POST['name']);
            }
            else {
                $name = $localProfessionalCurrentInformations->getName();
            }

            if (!empty($_POST['sector']))
            {
                $sector = htmlspecialchars($_POST['sector']);
            }
            else {
                $sector = $localProfessionalCurrentInformations->getSector();
            }
            if (!empty($_POST['getCeoFirstname']))
            {
                $firstname = htmlspecialchars($_POST['getCeoFirstname']);
            }
            else {
                $firstname = $localProfessionalCurrentInformations->getCeoFirstName();
            }
            if (!empty($_POST['lastname']))
            {
                $lastname = htmlspecialchars($_POST['lastname']);
            }
            else {
                $lastname = $localProfessionalCurrentInformations->getCeoLastName();
            }

            $localProfessional = new LocalProfessional(
                $name,
                $sector,
                $firstname,
                $lastname
            );
            $localProfessional->setAddress($addressUpdated);
            $localProfessional->setId($localProfessionalCurrentInformations->getId());

            $this->localProfessionalManager->editLocalProfessional($localProfessional);

            header('Location:/admin/informations-locales/professionnels-locaux');
        }
        else
        {
            $this->render('views/admin/informations_locales/local-professionals/_form-modify-local-professional.phtml', [], 'Infos locales - professionnels-locaux', 'admin');
        }
    }

    /// LOCATIONS
    public function locations() : void
    {
        $locations = $this->locationManager->getAllLocations();
        $this->render('views/admin/informations_locales/locations/lieux.phtml', ['locations' => $locations], 'Infos locales - lieux', 'admin');
    }
    public function addLocation() : void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerLocation']))
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

            header('Location:/admin/informations-locales/lieux');
        }
        else
        {
            $this->render('views/admin/informations_locales/locations/_form-add-location.phtml', [], 'Infos locales - locations', 'admin');
        }
    }
    public function modifyLocation(int $locationId) : void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifyLocation']))
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

            header('Location:/admin/informations-locales/lieux');
        }
        else
        {
            $this->render('views/admin/informations_locales/locations/_form-modify-location.phtml', [], 'Infos locales - locations', 'admin');
        }
    }

    // CAFETERIA
    public function cafeteriaDates() : void
    {
        $dates = $this->cafeteriaDateManager->getAllCafeteriaDates();

        $this->render('views/admin/cantine/cantine.phtml', ['cafeteria-weeks' => $dates], 'Dates cantine', 'admin');
    }
    public function newCafeteriaDates() : void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createNewYear']))
        {
            $yearStart = htmlspecialchars($_POST['yearStart']);
            $yearEnd = htmlspecialchars($_POST['yearEnd']);
            $toussaintStart = htmlspecialchars($_POST['toussaintStart']);
            $toussaintEnd = htmlspecialchars($_POST['toussaintEnd']);

            $dates = $this->cafeteriaDateManager->getAllCafeteriaDates();
            $this->render('views/admin/cantine/cantine.phtml', ['cafeteria-weeks' => $dates], 'dates cantine', 'admin');
        }
        else
        {
            $this->render('views/admin/cantine/_form_new-year.phtml', [], 'New year', 'admin');
        }
    }
    public function export() : void
    {
        $weeks = [];
        foreach ($_POST['weekNumber'] as $week)
        {
            $week = $this->cafeteriaDateManager->getCafeteriaDateByWeekNumber($week);
            $weekId = $week->getId();
            $ChildrenEnrolled = $this->cafeteriaDateManager->getAllChildrenEnrolledForWeek($weekId);

            $weeks[] = [$week, $ChildrenEnrolled];
        }
        //var_dump($weeks[0]);//first week
        //var_dump($weeks[0][0]->getWeekOfYear());//week
        //var_dump($weeks[0][1]);//childrenEnrolled
        //var_dump($weeks[0][1][0]);//first child
        //var_dump($weeks[0][1][0][0]->getAge());//child
        //var_dump($weeks[0][1][0][1]->getWeekOfYear());//child enrollment for week

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','Semaine');
        $sheet->setCellValue('B1','Nom de famille');
        $sheet->setCellValue('C1','Lundi');
        $sheet->setCellValue('D1','Mardi');
        $sheet->setCellValue('E1', 'Mercredi');
        $sheet->setCellValue('F1','Jeudi');
        $sheet->setCellValue('G1','Vendredi');
        $today = new DateTime();
        $formattedDate = $today->format('Y-m-d');
        $i = 2;
        foreach($weeks as $week)
        {
            $sheet->setCellValue('A'.$i, $week[0]->getWeekOfYear());
            foreach($week[1] as $child)
            {
                $i++;
                $sheet->setCellValue('A'.$i, $child[0]->getLastName());
                $sheet->setCellValue('B'.$i, $child[0]->getFirstName());
                $sheet->setCellValue('C'.$i, $child[1]->getMonday());
                $sheet->setCellValue('D'.$i, $child[1]->getTuesday());
                $sheet->setCellValue('E'.$i, $child[1]->getWednesday());
                $sheet->setCellValue('F'.$i, $child[1]->getThursday());
                $sheet->setCellValue('G'.$i, $child[1]->getFriday());
            }
            $i++;
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('data/inscriptions-cantine/'.$formattedDate.'xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename='.$formattedDate);
        //header('Location:/admin/cantine');
    }
}
?>