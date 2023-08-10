<?php
    class Location {
        private ?int $id;
        private string $name;
        private string $type;
        private string $telephone;
        private string $description;
        private Address $address;

        /**
         * @param string $name
         * @param string $type
         * @param string $telephone
         * @param string $description
         * @param Address $address
         */
        public function __construct(string $name, string $type, string $telephone, string $description, Address $address)
        {
            $this->name = $name;
            $this->type = $type;
            $this->telephone = $telephone;
            $this->description = $description;
            $this->address = $address;
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
        public function getType(): string
        {
            return $this->type;
        }

        /**
         * @param string $type
         */
        public function setType(string $type): void
        {
            $this->type = $type;
        }

        /**
         * @return string
         */
        public function getTelephone(): string
        {
            return $this->telephone;
        }

        /**
         * @param string $telephone
         */
        public function setTelephone(string $telephone): void
        {
            $this->telephone = $telephone;
        }

        /**
         * @return string
         */
        public function getDescription(): string
        {
            return $this->description;
        }

        /**
         * @param string $description
         */
        public function setDescription(string $description): void
        {
            $this->description = $description;
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