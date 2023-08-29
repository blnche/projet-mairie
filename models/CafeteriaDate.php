<?php
    class CafeteriaDate {
        private ?int $id;
        private int $week_of_year;
        private int $year;
        private ?string $monday;
        private ?string $tuesday;
        private ?string $wednesday;
        private ?string $thursday;
        private ?string $friday;
        private string $status;


        /**
         * @param int $week_of_year
         * @param int $year
         * @param string $status
         */
        public function __construct(int $week_of_year, int $year, string $status)
        {
            $this->week_of_year = $week_of_year;
            $this->year = $year;
            $this->status = $status;
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
         * @return int
         */
        public function getWeekOfYear(): int
        {
            return $this->week_of_year;
        }

        /**
         * @param int $week_of_year
         */
        public function setWeekOfYear(int $week_of_year): void
        {
            $this->week_of_year = $week_of_year;
        }

        /**
         * @return int
         */
        public function getYear(): int
        {
            return $this->year;
        }

        /**
         * @param int $year
         */
        public function setYear(int $year): void
        {
            $this->year = $year;
        }

        /**
         * @return string|null
         */
        public function getMonday(): ?string
        {
            return $this->monday;
        }

        /**
         * @param string|null $monday
         */
        public function setMonday(?string $monday): void
        {
            $this->monday = $monday;
        }

        /**
         * @return string|null
         */
        public function getTuesday(): ?string
        {
            return $this->tuesday;
        }

        /**
         * @param string|null $tuesday
         */
        public function setTuesday(?string $tuesday): void
        {
            $this->tuesday = $tuesday;
        }

        /**
         * @return string|null
         */
        public function getWednesday(): ?string
        {
            return $this->wednesday;
        }

        /**
         * @param string|null $wednesday
         */
        public function setWednesday(?string $wednesday): void
        {
            $this->wednesday = $wednesday;
        }

        /**
         * @return string|null
         */
        public function getThursday(): ?string
        {
            return $this->thursday;
        }

        /**
         * @param string|null $thursday
         */
        public function setThursday(?string $thursday): void
        {
            $this->thursday = $thursday;
        }

        /**
         * @return string|null
         */
        public function getFriday(): ?string
        {
            return $this->friday;
        }

        /**
         * @param string|null $friday
         */
        public function setFriday(?string $friday): void
        {
            $this->friday = $friday;
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

    }
?>