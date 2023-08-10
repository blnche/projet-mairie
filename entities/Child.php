<?php
    class Child {
        private ?int $id;
        private string $firstName;
        private string $lastName;
        private int $age;
        private User $parent;

        /**
         * @param string $firstName
         * @param string $lastName
         * @param int $age
         * @param User $parent
         */
        public function __construct(string $firstName, string $lastName, int $age, User $parent)
        {
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->age = $age;
            $this->parent = $parent;
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
         * @return int
         */
        public function getAge(): int
        {
            return $this->age;
        }

        /**
         * @param int $age
         */
        public function setAge(int $age): void
        {
            $this->age = $age;
        }

        /**
         * @return User
         */
        public function getParent(): User
        {
            return $this->parent;
        }

        /**
         * @param User $parent
         */
        public function setParent(User $parent): void
        {
            $this->parent = $parent;
        }
    }
?>