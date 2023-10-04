<?php
    class LocalProfessionalManager extends AbstractManager
    {
        private AddressManager $addressManager;
        public function __construct()
        {
            parent::__construct();
            $this->addressManager = new AddressManager();
        }

        public function addLocalProfessional(LocalProfessional $localProfessional) : LocalProfessional
        {
            $query = $this->db->prepare('
                INSERT INTO professionnels_locaux (name, sector, ceo_lastName, ceo_firstName, pl_address_id)
                VALUES (:name, :sector, :ceo_lastName, :ceo_firstName, :pl_address_id)
            ');
            $parameters = [
                'name' => $localProfessional->getName(),
                'sector' => $localProfessional->getSector(),
                'ceo_lastName' => $localProfessional->getCeoLastName(),
                'ceo_firstName' => $localProfessional->getCeoFirstName(),
                'pl_address_id' => $localProfessional->getAddress()->getId()
            ];
            $query->execute($parameters);

            $localProfessional->setId($this->db->lastInsertId());

            return $localProfessional;
        }

        public function editLocalProfessional(LocalProfessional $localProfessionalEdited) : LocalProfessional
        {
            $query = $this->db->prepare('
                UPDATE professionnels_locaux
                SET name = :name, sector = :sector,  ceo_lastName = :ceo_lastName, ceo_firstName = :ceo_firstName, pl_address_id = :pl_address_id
                WHERE id = :id
            ');
            $parameters = [
                'id' => $localProfessionalEdited->getId(),
                'name' => $localProfessionalEdited->getName(),
                'sector' => $localProfessionalEdited->getSector(),
                'ceo_lastName' => $localProfessionalEdited->getCeoLastName(),
                'ceo_firstName' => $localProfessionalEdited->getCeoFirstName(),
                'pl_address_id' => $localProfessionalEdited->getAddress()->getId()
            ];
            $query->execute($parameters);

            return $localProfessionalEdited;
        }

        public function getAllLocalProfessionals() : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM professionnels_locaux
            ');
            $query->execute();

            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            $localProfessionals = [];
            foreach($data as $localProfessional)
            {
                $newLocalProfessional = new LocalProfessional(
                    $localProfessional['name'],
                    $localProfessional['sector'],
                    $localProfessional['ceo_firstName'],
                    $localProfessional['ceo_lastName']
                );
                $newLocalProfessional->setAddress($this->addressManager->getAddressById($localProfessional['pl_address_id']));
                $newLocalProfessional->setId($localProfessional['id']);

                $localProfessionals[] = $newLocalProfessional;
            }

            return $localProfessionals;
        }

        public function getLocalProfessionalById($id) : LocalProfessional
        {
            $query = $this->db->prepare('
                SELECT *
                FROM professionnels_locaux
                WHERE id = :id
            ');
            $parameters = [
                'id' => $id
            ];
            $query->execute($parameters);

            $data = $query->fetch(PDO::FETCH_ASSOC);

            $newLocalProfessional = new LocalProfessional(
                $data['name'],
                $data['sector'],
                $data['ceo_firstName'],
                $data['ceo_lastName']
            );
            $address = $this->addressManager->getAddressById($data['pl_address_id']);
            $newLocalProfessional->setAddress($address);
            $newLocalProfessional->setId($data['id']);

            return $newLocalProfessional;
        }
    }
?>