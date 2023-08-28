<?php
    class UserManager extends AbstractManager {
        private AddressManager $addressManager;

        public function __construct()
        {
            parent::__construct();
            $this->addressManager = new AddressManager();
        }

        public function getAllUsers() : array
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
                $result['role']
            );
            $user->setFirstName($result['firstName']);
            $user->setLastName($result['lastName']);
            $user->setId($result['id']);
            $user->setAddress($this->addressManager->getAddressById($result['user_address_id']));

            return $user;
        }

        public function getUserByEmail (string $email) : User
        {
            $query = $this->db->prepare('
                SELECT * 
                FROM users
                WHERE email = :email
            ');
            $parameters = [
                'email' => $email
            ];
            $query->execute($parameters);

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $user = new User(
                $result['email'],
                $result['password'],
                $result['role']
            );

            if(!empty($result['firstName'])) {
                $user->setFirstName($result['firstName']);
            }
            if(!empty($result['lastName'])) {
                $user->setLastName($result['lastName']);
            }
            $user->setId($result['id']);
            $user->setAddress($this->addressManager->getAddressById($result['user_address_id']));

            return $user;
        }

        public function addUser (User $user) : User
        {
            $query = $this->db->prepare('
                INSERT INTO users (email, password, role, user_address_id)
                VALUES (:email, :password, :role, :user_address_id)
            ');
            $parameters = [
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'role' => $user->getRole(),
                'user_address_id' => $user->getAddress()->getId()
            ];
            $query->execute($parameters);

            $user->setId($this->db->lastInsertId());

            return $user;
        }

        public function editUser (User $userEdited) : User
        {
            $query = $this->db->prepare('
                UPDATE users
                SET email = :email, password = :password, firstName = :firstName, lastName = :lastName, user_address_id = :address_id
                WHERE id = :id
            ');
            $parameters = [
                'email' => $userEdited->getEmail(),
                'password' => $userEdited->getPassword(),
                'firstName' => $userEdited->getFirstName(),
                'lastName' => $userEdited->getLastName(),
                'address_id' => $userEdited->getAddress()->getId()
            ];
            $query->execute($parameters);

            return $userEdited;
        }

        public function deleteUser (User $user) : void
        {

        }
    }
?>