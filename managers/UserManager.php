<?php
require_once 'AbstractManager.php';
require_once 'AddressManager.php';

    class UserManager extends AbstractManager {
        private AddressManager $addressManager;

        public function __construct()
        {
            parent::__construct();
            $this->addressManager = new AddressManager();
        }

        public function index() : array
        {
            $query = $this->db->prepare('
                SELECT * 
                FROM users
                WHERE users.role = "ROLE_USER"
            ');
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getUserById (int $id) : User
        {
            $query = $this->db->prepare('
                SELECT * 
                FROM users
                WHERE id = :id
            ');
            $parameters = [
                'id' => $id
            ];
            $query->execute($parameters);

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $user = new User(
                $result['email'],
                $result['password'],
                $result['role'],
                $result['firstName'],
                $result['lastName']
            );

            $user->setId($result['id']);
            $user->setAddress($this->addressManager->getAddressById($result['user_address_id']));

            return $user;
        }
    }
?>