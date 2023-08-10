<?php
    class Picture {
        private ?int $id;
        private string $title;
        private string $url;

        /**
         * @param string $title
         * @param string $url
         */
        public function __construct(string $title, string $url)
        {
            $this->title = $title;
            $this->url = $url;
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
        public function getUrl(): string
        {
            return $this->url;
        }

        /**
         * @param string $url
         */
        public function setUrl(string $url): void
        {
            $this->url = $url;
        }

    }
?>