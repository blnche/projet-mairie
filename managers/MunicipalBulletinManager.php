<?php
//require_once 'AbstractManager.php';
    class MunicipalBulletinManager extends AbstractManager
    {
        public function getBulletins() : array
        {

        }

        public function create(MunicipalBulletin $municipalBulletin) : MunicipalBulletin
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