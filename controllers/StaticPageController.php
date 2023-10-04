<?php
class StaticPageController extends AbstractController
{
    // TOWN COUNCIL
    public function townCouncillors() : void
    {
        $this->render('views/public/mairie/conseil-municipal/elus.phtml', [], 'Les élus');
    }
    public function  localUrbanisationPlan() : void
    {
        $this->render('views/public/mairie/conseil-municipal/plu.phtml', [], 'Plan Local d\'Urbanisme');
    }

    // MUNICIPAL SERVICES
    public function municipalServices() : void
    {
        $this->render('views/public/mairie/services-municipaux/services-municipaux.phtml', [], 'Services Municipaux');
    }
    public function citizenCensus() : void
    {
        $this->render('views/public/mairie/services-municipaux/recensement.phtml', [], 'Recensement');
    }
    public function identityDocuments() : void
    {
        $this->render('views/public/mairie/services-municipaux/papiers-identite.phtml', [], 'Papiers d\'identité');
    }
    public function bookFunctionRoom() : void
    {
        $this->render('views/public/mairie/services-municipaux/location-salle.phtml', [], 'Louer une salle');
    }

    // FOOTER
    public function legalNotices() : void
    {
        $this->render('views/public/mentions-legales.phtml', [], 'Mentions Légales');
    }

    public function privacyPolicy() : void
    {
        $this->render('views/public/politique-confidentialite.phtml', [], 'Politique de confidentialité');
    }
}
?>