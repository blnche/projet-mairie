<?php
//require_once 'AbstractManager.php';
    class MunicipalCouncilReportManager extends AbstractManager
    {
        public function getAllMunicipalCouncilReports() : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM compte_rendus_conseil_municipaux
            ');
            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function addMunicipalCouncilReport(MunicipalCouncilReport $councilReport) : MunicipalCouncilReport
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