<?php
    class CafeteriaDate {
        private ?int $id;
        private int $week_of_year;
        private string $monday;
        private string $tuesday;
        private string $wednesday;
        private string $thursday;
        private string $friday;

        /**
         * @param int $week_of_year
         */
        public function __construct(int $week_of_year)
        {
            $this->week_of_year = $week_of_year;
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
         * @return string
         */
        public function getMonday(): string
        {
            return $this->monday;
        }

        /**
         * @param string $monday
         */
        public function setMonday(string $monday): void
        {
            $this->monday = $monday;
        }

        /**
         * @return string
         */
        public function getTuesday(): string
        {
            return $this->tuesday;
        }

        /**
         * @param string $tuesday
         */
        public function setTuesday(string $tuesday): void
        {
            $this->tuesday = $tuesday;
        }

        /**
         * @return string
         */
        public function getWednesday(): string
        {
            return $this->wednesday;
        }

        /**
         * @param string $wednesday
         */
        public function setWednesday(string $wednesday): void
        {
            $this->wednesday = $wednesday;
        }

        /**
         * @return string
         */
        public function getThursday(): string
        {
            return $this->thursday;
        }

        /**
         * @param string $thursday
         */
        public function setThursday(string $thursday): void
        {
            $this->thursday = $thursday;
        }

        /**
         * @return string
         */
        public function getFriday(): string
        {
            return $this->friday;
        }

        /**
         * @param string $friday
         */
        public function setFriday(string $friday): void
        {
            $this->friday = $friday;
        }
    }
?>