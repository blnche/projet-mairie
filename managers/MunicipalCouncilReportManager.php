<?php
//require_once 'AbstractManager.php';
    class MunicipalCouncilReportManager extends AbstractManager
    {
        public function getCouncilReports() : void /*array*/
        {

        }

        public function create(MunicipalCouncilReport $councilReport) : MunicipalCouncilReport
        {
            $query = $this->db->prepare('
                INSERT INTO compte_rendus_conseil_municipaux (date, url) 
                VALUES (:date, :url)
            ');
            $parameters = [
                'date' => $councilReport->getDate()->format('Y-m-d'),
                'url' => $councilReport->getUrl()
            ];
            $query->execute($parameters);

            $councilReport->setId($this->db->lastInsertId());

            return $councilReport;
        }
    }
?>