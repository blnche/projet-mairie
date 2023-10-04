<?php
class MunicipalBulletinManager extends AbstractManager
{
    public function getAllMunicipalBulletins() : array
    {
        $query = $this->db->prepare('
            SELECT *
            FROM bulletins_municipaux
        ');
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $municipalBulletins = [];

        foreach ($result as $municipalBulletin) {
            $municipalBulletin_date = new DateTime($municipalBulletin['date']);

            $newMunicipalBulletin = new MunicipalBulletin (
                $municipalBulletin_date,
                $municipalBulletin['url']
            );
            $newMunicipalBulletin->setId($municipalBulletin['id']);

            $municipalBulletins[] = $newMunicipalBulletin;
        }

        return $municipalBulletins;
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