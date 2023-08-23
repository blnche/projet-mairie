<?php
    class AssociationManager extends AbstractManager
    {
        private AddressManager $addressManager;
        public function __construct()
        {
            $this->addressManager = new AddressManager();
        }

        public function registerAssociation(Association $association) : Association
        {
            $query = $this->db->prepare('
                INSERT INTO associations (name, president_firstName, president_lastName, assoc_address_id)
                VALUES (:name, :president_firstName, :president_lastName, :assoc_address_id)
            ');
            $parameters = [
                'name' => $association->getName(),
                'president_firstName' => $association->getPresidentFirstName(),
                'president_lastName' => $association->getPresidentLastName(),
                'assoc_address_id' => $association->getAddress()->getId()
            ];
            $query->execute($parameters);

            $association->setId($this->db->lastInsertId());

            return $association;
        }

        public function getAll() : array
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
                    $association['president_lastName']
                );
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
                $data['president_lastName']
            );
            $address = $this->addressManager->getAddressById($data['assoc_address_id']);
            $newAssociation->setAddress($address);
            $newAssociation->setId($data['id']);

            return $newAssociation;
        }

        public function EditAssociation(int $id, Association $associationEdited) : void
        {
            $query = $this->db->prepare('
                UPDATE associations
                SET name = :name, president_firstName = :presidentFirstName, president_lastName = :presidentLastName
                WHERE id = :id
            ');
            $parameters = [
                'name' => $associationEdited->getName(),
                'presidentFirstName' => $associationEdited->getPresidentFirstName(),
                'presidentLastName' => $associationEdited->getPresidentLastName(),
                'id' => $id
            ];
            $query->execute($parameters);
        }
    }
?>