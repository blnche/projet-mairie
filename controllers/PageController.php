<?php
class PageController extends AbstractController
{
    private EventManager $eventManager;
    private MunicipalBulletinManager $bulletinManager;
    private MunicipalCouncilReportManager $councilReportManager;


    public function __construct()
    {
        $this->eventManager = new EventManager();
        $this->bulletinManager = new MunicipalBulletinManager();
        $this->councilReportManager = new MunicipalCouncilReportManager();

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

    public function projects() : void {
        $this->render('views/public/projets/projets.phtml', [],'Projets');
    }

    public function reside() : void {
        $this->render('views/public/vivre/vivre.phtml', [],'Vivre');
    }

    public function discover () : void {
        $this->render('views/public/decouvrir/decouvrir.phtml', [],'Découvrir');
    }

    public function everydayLife () : void {
        $this->render('views/public/pratique/pratique.phtml', [],'Pratique');
    }

    // ERROR
    public function error404() : void
    {
        $this->render('views/public/error404.phtml', [], 'Error 404');
    }
}
?>