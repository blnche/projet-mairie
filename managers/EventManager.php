<?php
require_once 'AbstractManager.php';

    class EventManager extends AbstractManager
    {
        public function getAllEvents() : array
        {
            $today = new DateTime();
            $query = $this->db->prepare('
                SELECT * 
                FROM events
                /*WHERE events.date > :today*/
            ');
            /*$parameters = ['today' => $today];*/
            $query->execute(/*$parameters*/);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>