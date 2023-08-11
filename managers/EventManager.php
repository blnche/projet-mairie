<?php
//require_once 'AbstractManager.php';

    class EventManager extends AbstractManager
    {
        public function getAllEvents() : array
        {
            $query = $this->db->prepare('
                SELECT * 
                FROM events
            ');
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getFutureEvents() : array
        {
            $today = new DateTime();
            $formattedDate = $today->format('Y-m-d');
            $query = $this->db->prepare('
                SELECT * 
                FROM events
                WHERE events.date > :today
            ');
            $parameters = ['today' => $formattedDate];
            $query->execute($parameters);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getPastEvents() : array
        {
            $today = new DateTime();
            $formattedDate = $today->format('Y-m-d');
            $query = $this->db->prepare('
                SELECT * 
                FROM events
                WHERE events.date < :today
            ');
            $parameters = ['today' => $formattedDate];
            $query->execute($parameters);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>