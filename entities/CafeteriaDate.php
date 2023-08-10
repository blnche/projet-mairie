<?php
    class CafeteriaDate {
        private ?int $id;
        private int $week_of_year;

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
    }
?>