<?php
// require_once 'AbstractController.php';
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
            $bulletins = $this->bulletinManager->getBulletins();
            $councilReports = $this->councilReportManager->getCouncilReports();

            return ['bulletins' => $bulletins, 'councilReports' => $councilReports];
        }
        public function uploadFile($fileType) : void
        {
            $today = new DateTime();

            if($fileType === 'compte-rendu') {
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $file = $_FILES['compte_rendu'];

                    $file_name = $file['name'];

                    $path = 'data/comptes-rendus-CM/' . $file_name;

                    move_uploaded_file($file['tmp_name'], $path);

                    $newCouncilReport = new MunicipalCouncilReport($today, $path);

                    $this->councilReportManager->create($newCouncilReport);

                    echo 'success';
                    header('Location:index.php?route=comptes-rendus-conseils-municipaux');
                } else {
                    $this->render('views/admin/comptes_rendus_cm/_form.phtml', []);
                }
            }
            if($fileType === 'bulletin')
            {
                if($_SERVER["REQUEST_METHOD"] === "POST")
                {
                    $file = $_FILES['bulletin'];

                    $file_name = $file['name'];

                    $path = 'data/bulletins-municipaux/'.$file_name;

                    move_uploaded_file($file['tmp_name'], $path);

                    $newMunicipalBulletin = new MunicipalBulletin($today, $path);

                    $this->bulletinManager->create($newMunicipalBulletin);

                    echo 'success';
                    header('Location:index.php?route=bulletins-municipaux');
                }
                else
                {
                    $this->render('views/admin/bulletins_municipaux/_form.phtml', []);
                }
            }
        }
    }
?>