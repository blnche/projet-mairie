<?php
    class AssociationManager extends AbstractManager
    {
        private AddressManager $addressManager;
        public function __construct()
        {
            parent::__construct();
            $this->addressManager = new AddressManager();
        }

        public function addAssociation(Association $association) : Association
        {
            $query = $this->db->prepare('
                INSERT INTO associations (name, president_firstName, president_lastName, status, assoc_address_id)
                VALUES (:name, :president_firstName, :president_lastName, :status, :assoc_address_id)
            ');
            $parameters = [
                'name' => $association->getName(),
                'president_firstName' => $association->getPresidentFirstName(),
                'president_lastName' => $association->getPresidentLastName(),
                'status' => $association->getStatus(),
                'assoc_address_id' => $association->getAddress()->getId()
            ];
            $query->execute($parameters);

            $association->setId($this->db->lastInsertId());

            return $association;
        }

        public function editAssociation(Association $associationEdited) : Association
        {
            $query = $this->db->prepare('
                UPDATE associations
                SET name = :name, president_firstName = :presidentFirstName, president_lastName = :presidentLastName, status = :status, assoc_address_id = :assoc_address_id
                WHERE id = :id
            ');
            $parameters = [
                'id' => $associationEdited->getId(),
                'name' => $associationEdited->getName(),
                'presidentFirstName' => $associationEdited->getPresidentFirstName(),
                'presidentLastName' => $associationEdited->getPresidentLastName(),
                'status' => $associationEdited->getStatus(),
                'assoc_address_id' => $associationEdited->getAddress()->getId()
            ];
            $query->execute($parameters);

            return $associationEdited;
        }

        public function getAllAssociations() : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM associations
            ');
            $query->execute();

            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            $associations = [];
            foreach($data as $association)
            {
                $newAssociation = new Association(
                    $association['name'],
                    $association['president_firstName'],
                    $association['president_lastName'],
                    $association['status']
                );
                $newAssociation->setAddress($this->addressManager->getAddressById($association['assoc_address_id']));
                $newAssociation->setId($association['id']);
                $associations[] = $newAssociation;
            }

            return $associations;
        }

        public function getAssociationById($id) : Association
        {
            $query = $this->db->prepare('
                SELECT *
                FROM associations
                WHERE id = :id
            ');
            $parameters = [
                'id' => $id
            ];
            $query->execute($parameters);

            $data = $query->fetch(PDO::FETCH_ASSOC);

            $newAssociation = new Association(
                $data['name'],
                $data['president_firstName'],
                $data['president_lastName'],
                $data['status']
            );
            $address = $this->addressManager->getAddressById($data['assoc_address_id']);
            $newAssociation->setAddress($address);
            $newAssociation->setId($data['id']);

            return $newAssociation;
        }
    }
?>