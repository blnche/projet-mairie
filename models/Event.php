<?php
    class Event {
        private ?int $id;
        private string $title;
        private datetime $date;
        private string $description;
        private Address $address;

        /**
         * @param string $title
         * @param datetime $date
         * @param string $description
         */
        public function __construct(string $title, datetime $date, string $description)
        {
            $this->title = $title;
            $this->date = $date;
            $this->description = $description;
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
        public function getTitle(): string
        {
            return $this->title;
        }

        /**
         * @param string $title
         */
        public function setTitle(string $title): void
        {
            $this->title = $title;
        }

        /**
         * @return datetime
         */
        public function getDate(): datetime
        {
            return $this->date;
        }

        /**
         * @param datetime $date
         */
        public function setDate(datetime $date): void
        {
            $this->date = $date;
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