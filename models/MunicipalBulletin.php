<?php
    class MunicipalBulletin {
        private ?int $id;
        private datetime $date;
        private string $url;

        /**
         * @param datetime $date
         * @param string $url
         */
        public function __construct(datetime $date, string $url)
        {
            $this->date = $date;
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