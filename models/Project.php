<?php
    class Project {
        private ?int $id;
        private string $title;
        private string $content;
        private array $deco_pictures;
        private Address $address;
        private Picture $picture;

        /**
         * @param string $title
         * @param string $content
         * @param Address $address
         */
        public function __construct(string $title, string $content, Address $address)
        {
            $this->title = $title;
            $this->content = $content;
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
         * @return string
         */
        public function getContent(): string
        {
            return $this->content;
        }

        /**
         * @param string $content
         */
        public function setContent(string $content): void
        {
            $this->content = $content;
        }

        /**
         * @return array
         */
        public function getDecoPictures(): array
        {
            return $this->deco_pictures;
        }

        /**
         * @param array $deco_pictures
         */
        public function setDecoPictures(array $deco_pictures): void
        {
            $this->deco_pictures = $deco_pictures;
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

        /**
         * @return Picture
         */
        public function getPicture(): Picture
        {
            return $this->picture;
        }

        /**
         * @param Picture $picture
         */
        public function setPicture(Picture $picture): void
        {
            $this->picture = $picture;
        }

    }
?>