<?php
// require_once 'AbstractController.php';
    class FileController extends AbstractController
    {
        private MunicipalBulletinManager $bulletinManager;
        private MunicipalCouncilReportManager $councilReportManger;

        public function __construct()
        {
            $this->bulletinManager = new MunicipalBulletinManager();
            $this->councilReportManger = new MunicipalCouncilReportManager();
        }

        public function documents() : array
        {
            $bulletins = $this->bulletinManager->getBulletins();
            $councilReports = $this->councilReportManger->getCouncilReports();

            return ['bulletins' => $bulletins, 'councilReports' => $councilReports];
        }
        public function uploadFile() : void
        {

        }
    }
?>