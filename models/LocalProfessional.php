<?php
    class LocalProfessional {
        private ?int $id;
        private string $name;
        private string $sector;
        private string $ceo_firstName;
        private string $ceo_lastName;

        /**
         * @param string $name
         * @param string $sector
         * @param string $ceo_firstName
         * @param string $ceo_lastName
         */
        public function __construct(string $name, string $sector, string $ceo_firstName, string $ceo_lastName)
        {
            $this->name = $name;
            $this->sector = $sector;
            $this->ceo_firstName = $ceo_firstName;
            $this->ceo_lastName = $ceo_lastName;
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
        public function getSector(): string
        {
            return $this->sector;
        }

        /**
         * @param string $sector
         */
        public function setSector(string $sector): void
        {
            $this->sector = $sector;
        }

        /**
         * @return string
         */
        public function getCeoFirstName(): string
        {
            return $this->ceo_firstName;
        }

        /**
         * @param string $ceo_firstName
         */
        public function setCeoFirstName(string $ceo_firstName): void
        {
            $this->ceo_firstName = $ceo_firstName;
        }

        /**
         * @return string
         */
        public function getCeoLastName(): string
        {
            return $this->ceo_lastName;
        }

        /**
         * @param string $ceo_lastName
         */
        public function setCeoLastName(string $ceo_lastName): void
        {
            $this->ceo_lastName = $ceo_lastName;
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