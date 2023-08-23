<?php
    class Association {
        private ?int $id;
        private string $name;
        private string $president_firstName;
        private string $president_lastName;
        private Address $address;

        /**
         * @param string $name
         * @param string $president_firstName
         * @param string $president_lastName
         */
        public function __construct(string $name, string $president_firstName, string $president_lastName)
        {
            $this->name = $name;
            $this->president_firstName = $president_firstName;
            $this->president_lastName = $president_lastName;
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
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * @param string $name
         */
        public function setName(string $name): void
        {
            $this->name = $name;
        }

        /**
         * @return string
         */
        public function getPresidentFirstName(): string
        {
            return $this->president_firstName;
        }

        /**
         * @param string $president_firstName
         */
        public function setPresidentFirstName(string $president_firstName): void
        {
            $this->president_firstName = $president_firstName;
        }

        /**
         * @return string
         */
        public function getPresidentLastName(): string
        {
            return $this->president_lastName;
        }

        /**
         * @param string $president_lastName
         */
        public function setPresidentLastName(string $president_lastName): void
        {
            $this->president_lastName = $president_lastName;
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