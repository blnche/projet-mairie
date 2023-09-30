<?php
    class Post {
        private ?int $id;
        private string $title;
        private ?string $content;
        private ?Post $parentPage;
        private string $status;
        private datetime $created_date;
        private ?datetime $posted_date;
        private ?Picture $picture;

        /**
         * @param string $title
         * @param string $status
         * @param datetime $created_date
         * @param datetime $posted_date
         */
        public function __construct(string $title, string $status, datetime $created_date)
        {
            $this->title = $title;
            $this->status = $status;
            $this->created_date = $created_date;
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
        public function getContent(): ?string
        {
            return $this->content;
        }

        /**
         * @param string $content
         */
        public function setContent(?string $content): void
        {
            $this->content = $content;
        }

        /**
         * @return string
         */
        public function getParentPage(): ?Post
        {
            return $this->parentPage;
        }

        /**
         * @param string $page
         */
        public function setParentPage(?Post $parentPage): void
        {
            $this->parentPage = $parentPage;
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
        public function getPostedDate(): ?datetime
        {
            return $this->posted_date;
        }

        /**
         * @param datetime $posted_date
         */
        public function setPostedDate(?datetime $posted_date): void
        {
            $this->posted_date = $posted_date;
        }

        /**
         * @return Picture
         */
        public function getPicture(): ?Picture
        {
            return $this->picture;
        }

        /**
         * @param Picture $picture
         */
        public function setPicture(?Picture $picture): void
        {
            $this->picture = $picture;
        }

    }
?>