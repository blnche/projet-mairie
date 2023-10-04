<?php
class PageController extends AbstractController
{
    private EventManager $eventManager;
    private MunicipalBulletinManager $bulletinManager;
    private MunicipalCouncilReportManager $councilReportManager;
    private LocalProfessionalManager $localProfessionnalManager;
    private AssociationManager $associationManager;


    public function __construct()
    {
        $this->eventManager = new EventManager();
        $this->bulletinManager = new MunicipalBulletinManager();
        $this->councilReportManager = new MunicipalCouncilReportManager();
        $this->localProfessionnalManager = new LocalProfessionalManager();
        $this->associationManager = new AssociationManager();

    }

    // DASHBOARD
    public function publicHomepage() : void
    {
        $events = $this->eventManager->getFutureEvents();

        $this->render('views/public/homepage.phtml', ['events' => $events], 'Accueil');
    }

    // TOWN HALL
    public function townHall() : void
    {
        $this->render('views/public/mairie/mairie.phtml', [], 'Mairie');
    }

    /// TOWN COUNCIL
    public function townCouncil() : void
    {
        $bm = $this->bulletinManager->getAllMunicipalBulletins();
        $crcm = $this->councilReportManager->getAllMunicipalCouncilReports();

        $this->render('views/public/mairie/conseil-municipal/conseil-municipal.phtml', ['bm' => $bm, 'crcm' => $crcm], 'Conseil Municipal');
    }
    public function municipalCouncilReports() : void
    {
        $comptes_rendus = $this->councilReportManager->getAllMunicipalCouncilReports();

        $this->render('views/public/mairie/conseil-municipal/comptes-rendus-cm.phtml', ['comptes-rendus' => $comptes_rendus], 'Comptes rendus des conseils municipaux');
    }
    public function municipalBulletins() : void
    {
        $bulletins = $this->bulletinManager->getAllMunicipalBulletins();

        $this->render('views/public/mairie/conseil-municipal/bulletins-municipaux.phtml', ['bulletins' => $bulletins], 'Bulletins Municipaux');
    }

    // PROJETS
    public function projects() : void {
        $this->render('views/public/projets/projets.phtml', [],'Projets');
    }

    // VIVRE
    public function reside() : void {
        $this->render('views/public/vivre/vivre.phtml', [],'Vivre');
    }
    public function localProfessionals() : void
    {
        $localProfessionals = $this->localProfessionnalManager->getAllLocalProfessionals();
        $this->render('views/public/vivre/professionnels-locaux.phtml', ['local-professionals' => $localProfessionals], 'Professionnels Locaux');
    }
    public function associations() : void
    {
        $associations = $this->associationManager->getAllAssociations();
        $this->render('views/public/vivre/associations.phtml', ['associations' => $associations], 'Associations');
    }
    
    // PRATIQUE
    public function everydayLife () : void {
        $this->render('views/public/pratique/pratique.phtml', [],'Pratique');
    }
    public function postOffice() : void {
        $this->render('views/public/pratique/poste.phtml', [],'La Poste');
    }

    // ERROR
    public function error404() : void
    {
        $this->render('views/public/error404.phtml', [], 'Error 404');
    }
}
?>