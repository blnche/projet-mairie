<?php
//require_once 'AbstractManager.php';
    class AddressManager extends AbstractManager
    {
        public function getAddressById($id) : Address
        {
            $query = $this->db->prepare('
                SELECT *
                FROM addresses
                WHERE id = :id
            ');
            $parameters = [
                'id' => $id
            ];
            $query->execute($parameters);

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $address = new Address(
                $result['code_postal'],
                $result['commune'],
                $result['address']
            );

            $address->setId($result['id']);

            return $address;
        }
    }
?>