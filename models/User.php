<?php
    class User {
        private ?int $id;
        private string $email;
        private string $password;
        private string $role;
        private string $firstName;
        private string $lastName;
        private Address $address;

        /**
         * @param string $email
         * @param string $password
         * @param string $role
         */
        public function __construct(string $email, string $password, string $role)
        {
            $this->email = $email;
            $this->password = $password;
            $this->role = $role;
        }

        /**
         * @return int|null
         */
        public function getId(): ?int
        {
            return $this->id;
        }

        /**
         * @param int|null $id
         */
        public function setId(?int $id): void
        {
            $this->id = $id;
        }

        /**
         * @return string
         */
        public function getEmail(): string
        {
            return $this->email;
        }

        /**
         * @param string $email
         */
        public function setEmail(string $email): void
        {
            $this->email = $email;
        }

        /**
         * @return string
         */
        public function getPassword(): string
        {
            return $this->password;
        }

        /**
         * @param string $password
         */
        public function setPassword(string $password): void
        {
            $this->password = $password;
        }

        /**
         * @return string
         */
        public function getRole(): string
        {
            return $this->role;
        }

        /**
         * @param string $role
         */
        public function setRole(string $role): void
        {
            $this->role = $role;
        }

        /**
         * @return string
         */
        public function getFirstName(): string
        {
            return $this->firstName;
        }

        /**
         * @param string $firstName
         */
        public function setFirstName(string $firstName): void
        {
            $this->firstName = $firstName;
        }

        /**
         * @return string
         */
        public function getLastName(): string
        {
            return $this->lastName;
        }

        /**
         * @param string $lastName
         */
        public function setLastName(string $lastName): void
        {
            $this->lastName = $lastName;
        }

        /**
         * @return Address
         */
        public function getAddress(): Address
        {
            return $this->address;
        }

        /**
         * @param Address $address
         */
        public function setAddress(Address $address): void
        {
            $this->address = $address;
        }

    }
?>