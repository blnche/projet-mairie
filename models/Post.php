<?php
    class Post {
        private ?int $id;
        private string $title;
        private string $content;
        private string $page;
        private string $status;
        private Address $address;
        private datetime $created_date;
        private datetime $posted_date;
        private array $deco_pictures;
        private Picture $picture;

        /**
         * @param string $title
         * @param string $content
         * @param string $page
         * @param string $status
         * @param Address $address
         * @param datetime $created_date
         * @param datetime $posted_date
         */
        public function __construct(string $title, string $content, string $page, string $status, Address $address, datetime $created_date, datetime $posted_date)
        {
            $this->title = $title;
            $this->content = $content;
            $this->page = $page;
            $this->status = $status;
            $this->address = $address;
            $this->created_date = $created_date;
            $this->posted_date = $posted_date;
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
         * @return string
         */
        public function getPage(): string
        {
            return $this->page;
        }

        /**
         * @param string $page
         */
        public function setPage(string $page): void
        {
            $this->page = $page;
        }

        /**
         * @return string
         */
        public function getStatus(): string
        {
            return $this->status;
        }

        /**
         * @param string $status
         */
        public function setStatus(string $status): void
        {
            $this->status = $status;
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
         * @return datetime
         */
        public function getCreatedDate(): datetime
        {
            return $this->created_date;
        }

        /**
         * @param datetime $created_date
         */
        public function setCreatedDate(datetime $created_date): void
        {
            $this->created_date = $created_date;
        }

        /**
         * @return datetime
         */
        public function getPostedDate(): datetime
        {
            return $this->posted_date;
        }

        /**
         * @param datetime $posted_date
         */
        public function setPostedDate(datetime $posted_date): void
        {
            $this->posted_date = $posted_date;
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