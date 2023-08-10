<?php
    class Address {
        private ?int $id;
        private string $address;
        private string $code_postal;
        private string $commune;

        /**
         * @param string $code_postal
         * @param string $commune
         * @param string $address
         */
        public function __construct(string $code_postal, string $commune, string $address)
        {
            $this->code_postal = $code_postal;
            $this->commune = $commune;
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
        public function getCodePostal(): string
        {
            return $this->code_postal;
        }

        /**
         * @param string $code_postal
         */
        public function setCodePostal(string $code_postal): void
        {
            $this->code_postal = $code_postal;
        }

        /**
         * @return string
         */
        public function getCommune(): string
        {
            return $this->commune;
        }

        /**
         * @param string $commune
         */
        public function setCommune(string $commune): void
        {
            $this->commune = $commune;
        }

        /**
         * @return string
         */
        public function getAddress(): string
        {
            return $this->address;
        }

        /**
         * @param string $address
         */
        public function setAddress(string $address): void
        {
            $this->address = $address;
        }


    }
?>