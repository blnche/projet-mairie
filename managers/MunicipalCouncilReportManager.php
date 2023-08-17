<?php
//require_once 'AbstractManager.php';
    class MunicipalCouncilReportManager extends AbstractManager
    {
        public function getCouncilReports() : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM compte_rendus_conseil_municipaux
            ');
            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
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