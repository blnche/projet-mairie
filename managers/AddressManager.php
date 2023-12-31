<?php
    class AddressManager extends AbstractManager
    {
        public function getAllAddresses() : array {
            $query = $this->db->prepare('
                SELECT * 
                FROM addresses
            ');
            $query->execute();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            $addresses = [];

            foreach ($result as $address) {
                $newAddress = new Address (
                    $address['code_postal'],
                    $address['commune'],
                    $address['address']
                );

                $newAddress->setId($address['id']);

                $addresses[] = $newAddress;
            }

            return $addresses;
        }
        public function getAddressById($id) : ?Address
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

            if ($result === false) {
                return null;
            } else {
                $address = new Address(
                    $result['code_postal'],
                    $result['commune'],
                    $result['address']
                );

                $address->setId($result['id']);

                return $address;
            }
        }

        public function addAddress(Address $address) : Address
        {
            $query = $this->db->prepare('
                INSERT INTO addresses (address, code_postal, commune) 
                VALUES (:address, :code_postal, :commune)
            ');
            $parameters = [
                'address' => $address->getAddress(),
                'code_postal' => $address->getCodePostal(),
                'commune' => $address->getCommune()
            ];
            $query->execute($parameters);

            $address->setId($this->db->lastInsertId());

            return $address;
        }

        public function editAddress(Address $address) : Address
        {
            $query = $this->db->prepare('
                UPDATE addresses
                SET address = :address, code_postal = :code_postal, commune = :commune
                WHERE id = :id
            ');
            $parameters = [
                'id' => $address->getId(),
                'address' => $address->getAddress(),
                'code_postal' => $address->getCodePostal(),
                'commune' => $address->getCommune()
            ];
            $query->execute($parameters);

            return $address;

        }
    }
?>