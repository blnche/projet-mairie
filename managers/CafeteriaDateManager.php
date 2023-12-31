<?php
    class CafeteriaDateManager extends AbstractManager
    {
        private ChildManager $childManager;

        public function __construct()
        {
            parent::__construct();
            $this->childManager = new ChildManager();
        }

        public function getAllCafeteriaDates() : array
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
                    $week['week_of_year'],
                    $week['year'],
                    $week['status']
                );
                $newWeek->setMonday($week['monday']);
                $newWeek->setTuesday($week['tuesday']);
                $newWeek->setWednesday($week['wednesday']);
                $newWeek->setThursday($week['thursday']);
                $newWeek->setFriday($week['friday']);
                $newWeek->setId($week['id']);

                $weeks[] = $newWeek;
            }
            return $weeks;
        }

        public function getCafeteriaDateByWeekNumber($weekNumber) : ?CafeteriaDate
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

            if($week) {
                $cafeteriaDate = new CafeteriaDate(
                    $week['week_of_year'],
                    $week['year'],
                    $week['status']
                );
                $cafeteriaDate->setMonday($week['monday']);
                $cafeteriaDate->setTuesday($week['tuesday']);
                $cafeteriaDate->setWednesday($week['wednesday']);
                $cafeteriaDate->setThursday($week['thursday']);
                $cafeteriaDate->setFriday($week['friday']);
                $cafeteriaDate->setId($week['id']);

                return $cafeteriaDate;
            } else {
                return null;
            }
        }
        public function getCafeteriaDateById(int $weekId) : ?CafeteriaDate
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
            
            if($week) {
                $cafeteriaDate = new CafeteriaDate(
                    $week['week_of_year'],
                    $week['year'],
                    $week['status']
                );
                $cafeteriaDate->setMonday($week['monday']);
                $cafeteriaDate->setTuesday($week['tuesday']);
                $cafeteriaDate->setWednesday($week['wednesday']);
                $cafeteriaDate->setThursday($week['thursday']);
                $cafeteriaDate->setFriday($week['friday']);
                $cafeteriaDate->setId($week['id']);
    
                return $cafeteriaDate;
            } else {
                return null;
            }
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

        public function getEnrollmentCafeteriaDatesByChildId(int $childId) : ?array
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
            
            $child = $this->childManager->getChildById($childId);
            //$childEnrollments[] = $child->getFirstName();
            
            if($results) {
                
                foreach ($results as $result)
                {
                    
                    $week = $this->getCafeteriaDateById($result['dates_cantine_id']);
                    
                    $enrollments = [];
                    if($week === null) {
                        $childEnrollments[] = $enrollments;
                    } else {
                        $enrollment = new CafeteriaDate(
                            $week->getWeekOfYear(),
                            $week->getYear(),
                            $week->getStatus()
                        );
                        $enrollment->setMonday($result['monday']);
                        $enrollment->setTuesday($result['tuesday']);
                        $enrollment->setWednesday($result['wednesday']);
                        $enrollment->setThursday($result['thursday']);
                        $enrollment->setFriday($result['friday']);
                        $enrollment->setId($week->getId());
        
                        $childEnrollments[] = $enrollment;
                    }
                    
                }

                return $childEnrollments;
                
            } else {
                $childEnrollments[] = [];
                return $childEnrollments;
            }

            
        }

        public function getEnrollmentForWeekByChildId(int $weekId, int $childId) : ?array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM inscription_child_cantine
                WHERE children_id = :childId AND dates_cantine_id = :weekId
            ');
            $parameters = [
                'childId' => $childId,
                'weekId' => $weekId
            ];
            $query->execute($parameters);

            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                $child = $this->childManager->getChildById($childId);

                $childEnrollments = [];
    
                $week = $this->getCafeteriaDateById($weekId);
    
                $enrollment = new CafeteriaDate(
                    $week->getWeekOfYear(),
                    $week->getYear(),
                    $week->getStatus()
                );
                $enrollment->setMonday($result['monday']);
                $enrollment->setTuesday($result['tuesday']);
                $enrollment->setWednesday($result['wednesday']);
                $enrollment->setThursday($result['thursday']);
                $enrollment->setFriday($result['friday']);
    
                $childEnrollments = [$child, $enrollment];
    
                return $childEnrollments;
            } else {
                return null;
            }
            
        }

        public function getAllChildrenEnrolledForWeek($weekId) : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM inscription_child_cantine
                WHERE dates_cantine_id = :weekId
            ');
            $parameters = [
                'weekId' => $weekId
            ];
            $query->execute($parameters);

            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            $ChildrenEnrolled = [];

            foreach($result as $enrollment)
            {
                $childEnrollments = $this->getEnrollmentForWeekByChildId($weekId, $enrollment['children_id']);

                $ChildrenEnrolled[] = $childEnrollments;
            }

            return $ChildrenEnrolled;
        }
        public function addCafeteriaDate(CafeteriaDate $week) : CafeteriaDate
        {
            $query = $this->db->prepare('
                INSERT INTO dates_cantine (week_of_year, year, status) 
                VALUES (:week_of_year, :year, :status)
            ');
            $parameters = [
                'week_of_year' => $week->getWeekOfYear(),
                'year' => $week->getYear(),
                'status' => $week->getStatus()
            ];
            $query->execute($parameters);

            $week->setId($this->db->lastInsertId());

            return $week;
        }
        public function editCafeteriaDate(CafeteriaDate $week) : CafeteriaDate
        {
            $query = $this->db->prepare('
                UPDATE dates_cantine
                SET monday = :monday, tuesday = :tuesday, wednesday = :wednesday, thursday = :thursday, friday = :friday
                WHERE id = :id
            ');
            $parameters = [
                'id' => $week->getId(),
                'monday' => $week->getMonday(),
                'tuesday' => $week->getTuesday(),
                'wednesday' => $week->getWednesday(),
                'thursday' => $week->getThursday(),
                'friday' => $week->getFriday()
            ];
            $query->execute($parameters);

            return $week;
        }
    }
?>