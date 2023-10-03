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

            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            $municipalCouncilReports = [];

            foreach ($result as $municipalCouncilReport) {
                $municipalCouncilReport_date = new DateTime($municipalCouncilReport['date']);

                $newMunicipalCouncilReport = new MunicipalCouncilReport (
                    $municipalCouncilReport_date,
                    $municipalCouncilReport['url']
                );
                $newMunicipalCouncilReport->setId($municipalCouncilReport['id']);

                $municipalCouncilReports[] = $newMunicipalCouncilReport;
            }

            return $municipalCouncilReports;
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