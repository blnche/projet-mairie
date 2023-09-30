<?php
class FileController extends AbstractController
{
    private MunicipalBulletinManager $bulletinManager;
    private MunicipalCouncilReportManager $councilReportManager;

    public function __construct()
    {
        $this->bulletinManager = new MunicipalBulletinManager();
        $this->councilReportManager = new MunicipalCouncilReportManager();
    }

    public function documents() : array
    {
        $bulletins = $this->bulletinManager->getAllMunicipalBulletins();
        $councilReports = $this->councilReportManager->getAllMunicipalCouncilReports();

        return ['bulletins' => $bulletins, 'councilReports' => $councilReports];
    } //needed? 
    
    public function uploadFile($fileType) : void
    {
        $today = new DateTime();

        if($fileType === 'compte-rendu') {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $file = $_FILES['compte_rendu'];

                $file_name = htmlspecialchars($file['name']);

                $path = 'data/comptes-rendus-CM/' . $file_name;

                move_uploaded_file($file['tmp_name'], $path);

                $newCouncilReport = new MunicipalCouncilReport($today, '/projet-final/projet-mairie/'.$path);

                $this->councilReportManager->addMunicipalCouncilReport($newCouncilReport);

                echo 'success';
                header('Location:/projet-final/projet-mairie/admin/comptes-rendus-conseils-municipaux');
            }
            else
            {
                $this->render('views/admin/comptes_rendus_cm/_form.phtml', [], 'Comptes rendus des CM', 'admin');
            }
        }
        if($fileType === 'bulletin')
        {
            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $file = $_FILES['bulletin'];

                $file_name = htmlspecialchars($file['name']);

                $path = 'data/bulletins-municipaux/'.$file_name;

                move_uploaded_file($file['tmp_name'], $path);

                $newMunicipalBulletin = new MunicipalBulletin($today, $path);

                $this->bulletinManager->addMunicipalBulletin($newMunicipalBulletin);

                echo 'success';
                header('Location:/projet-final/projet-mairie/admin/bulletins-municipaux');
            }
            else
            {
                $this->render('views/admin/bulletins_municipaux/_form.phtml', [], 'Bulletins municipaux', 'admin');
            }
        }
    }
}
?>