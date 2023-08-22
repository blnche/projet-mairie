<?php
    class CafeteriaDateManager extends AbstractManager
    {
        private ChildManager $childManager;

        public function __construct()
        {
            parent::__construct();
            $this->childManager = new ChildManager();
        }

        public function getCafeteriaDates() : array
        {
            $query =$this->db->prepare('
                SELECT *
                FROM dates_cantine
            ');
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            $weeks = [];
            foreach($result as $week)
            {
                $newWeek = new CafeteriaDate(
                    $week['week_of_year']
                );
                $newWeek->setMonday($week['monday']);
                $newWeek->setTuesday($week['tuesday']);
                $newWeek->setWednesday($week['wednesday']);
                $newWeek->setThursday($week['thursday']);
                $newWeek->setFriday($week['friday']);
                $newWeek->setId($week['id']);

                $weeks [] = $newWeek;
            }
            return $weeks;
        }

        public function getCafeteriaDateByWeekNumber($weekNumber) : CafeteriaDate
        {
            $query = $this->db->prepare('
                SELECT *
                FROM dates_cantine
                WHERE week_of_year = :weekNumber
            ');
            $parameters = [
                'weekNumber' => $weekNumber
            ];
            $query->execute($parameters);
            $week = $query->fetch(PDO::FETCH_ASSOC);

            $cafeteriaDate = new CafeteriaDate(
                $week['week_of_year']
            );
            $cafeteriaDate->setMonday($week['monday']);
            $cafeteriaDate->setTuesday($week['tuesday']);
            $cafeteriaDate->setWednesday($week['wednesday']);
            $cafeteriaDate->setThursday($week['thursday']);
            $cafeteriaDate->setFriday($week['friday']);
            $cafeteriaDate->setId($week['id']);

            return $cafeteriaDate;
        }
        public function getCafeteriaDateById($weekId) : CafeteriaDate
        {
            $query = $this->db->prepare('
                SELECT *
                FROM dates_cantine
                WHERE id = :id
            ');
            $parameters = [
                'id' => $weekId
            ];
            $query->execute($parameters);
            $week = $query->fetch(PDO::FETCH_ASSOC);

            $cafeteriaDate = new CafeteriaDate(
                $week['week_of_year']
            );
            $cafeteriaDate->setMonday($week['monday']);
            $cafeteriaDate->setTuesday($week['tuesday']);
            $cafeteriaDate->setWednesday($week['wednesday']);
            $cafeteriaDate->setThursday($week['thursday']);
            $cafeteriaDate->setFriday($week['friday']);
            $cafeteriaDate->setId($week['id']);

            return $cafeteriaDate;
        }

        public function EnrollChildCafeteria(CafeteriaDate $week, Child $child, array $days) : void
        {
            $query = $this->db->prepare('
                INSERT INTO inscription_child_cantine (children_id, dates_cantine_id, monday, tuesday, wednesday, thursday, friday) 
                VALUES (:childId, :cafeteriaId, :monday, :tuesday, :wednesday, :thursday, :friday)
            ');
            $parameters = [
                'childId' => $child->getId(),
                'cafeteriaId' => $week->getId(),
                'monday' => $days['monday'],
                'tuesday' => $days['tuesday'],
                'wednesday' => $days['wednesday'],
                'thursday' => $days['thursday'],
                'friday' => $days['friday']
            ];
            $query->execute($parameters);
        }

        public function getEnrollmentCafeteriaDatesByChildId(int $childId) : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM inscription_child_cantine
                WHERE children_id = :childId
            ');
            $parameters = [
                'childId' => $childId
            ];
            $query->execute($parameters);

            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $result)
            {
                $week = $this->getCafeteriaDateById($result['dates_cantine_id']);
                $enrollment =
                    [
                        'childId' => $result['children_id'],
                        'dateId' => $result['dates_cantine_id'],
                        'monday' => $result['monday'],
                        'tuesday' => $result['tuesday'],
                        'wednesday' => $result['wednesday'],
                        'thursday' => $result['thursday'],
                        'friday' => $result['friday']
                    ];
                $enrollments[] = ['week' => [$week->getWeekOfYear(),$enrollment]];
            }

            return $enrollments;
        }
    }
?>