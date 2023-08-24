<?php
    class LocationManager extends AbstractManager
    {
        private AddressManager $addressManager;
        public function __construct()
        {
            parent::__construct();
            $this->addressManager = new AddressManager();
        }
        public function addLocation(Location $location) : Location
        {
            $query = $this->db->prepare('
                INSERT INTO locations (name, type, telephone, description, loca_address_id) 
                VALUES (:name, :type, :telephone, :description, :loca_address_id)
            ');
            $parameters = [
                'name' => $location->getName(),
                'type' => $location->getType(),
                'telephone' => $location->getTelephone(),
                'description' => $location->getDescription(),
                'loca_address_id' => $location->getAddress()->getId()
            ];
            $query->execute($parameters);

            $location->setId($this->db->lastInsertId());

            return $location;
        }

        public function editLocation(Location $locationEdited) : Location
        {
            $query = $this->db->prepare('
                UPDATE locations
                SET name = :name, type = :type, telephone = :telephone, description = :description, loca_address_id = :loca_address_id
                WHERE id = :id
            ');
            $parameters = [
                'id' => $locationEdited->getId(),
                'name' => $locationEdited->getName(),
                'type' => $locationEdited->getType(),
                'telephone' => $locationEdited->getTelephone(),
                'description' => $locationEdited->getDescription(),
                'loca_address_id' => $locationEdited->getAddress()->getId()
            ];
            $query->execute($parameters);

            return $locationEdited;
        }


        public function getAllLocations() : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM locations
            ');
            $query->execute();

            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            $locations = [];
            foreach($data as $location)
            {
                $newLocation = new Location(
                    $location['name'],
                    $location['type'],
                    $location['telephone'],
                    $location['description']
                );
                $newLocation->setId($location['id']);
                $locations[] = $newLocation;
            }

            return $locations;
        }

        public function getLocationById($id) : Location
        {
            $query = $this->db->prepare('
                SELECT *
                FROM locations
                WHERE id = :id
            ');
            $parameters = [
                'id' => $id
            ];
            $query->execute($parameters);

            $data = $query->fetch(PDO::FETCH_ASSOC);

            $newLocation = new Location(
                $data['name'],
                $data['type'],
                $data['telephone'],
                $data['description']
            );
            $address = $this->addressManager->getAddressById($data['loca_address_id']);
            $newLocation->setAddress($address);
            $newLocation->setId($data['id']);

            return $newLocation;
        }
    }
?>