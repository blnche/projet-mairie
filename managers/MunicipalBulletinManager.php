<?php
//require_once 'AbstractManager.php';
    class MunicipalBulletinManager extends AbstractManager
    {
        public function getAllMunicipalBulletins() : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM bulletins_municipaux
            ');
            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function addMunicipalBulletin(MunicipalBulletin $municipalBulletin) : MunicipalBulletin
        {
            $query = $this->db->prepare('
                INSERT INTO bulletins_municipaux (date, url) 
                VALUES (:date, :url)
            ');
            $parameters = [
                'date' => $municipalBulletin->getDate()->format('Y-m-d'),
                'url' => $municipalBulletin->getUrl()
            ];
            $query->execute($parameters);

            $municipalBulletin->setId($this->db->lastInsertId());

            return $municipalBulletin;
        }
    }
?>