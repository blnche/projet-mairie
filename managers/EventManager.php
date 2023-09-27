<?php
//require_once 'AbstractManager.php';

    class EventManager extends AbstractManager
    {
        private AddressManager $addressManager;

        public function __construct()
        {
            parent::__construct();
            $this->addressManager = new AddressManager();
        }
        public function getAllEvents() : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM events
            ');
            $query->execute();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            $events = [];

            foreach ($result as $event) {
                $event_date = new DateTime($event['date']);
                $newEvent = new Event(
                    $event['title'],
                    $event_date,
                    $event['description']
                );
                $newEvent->setId($event['id']);
                if (!empty($event['event_address_id'])) {
                    $newEvent->setAddress($this->addressManager->getAddressById($event['event_address_id']));
                }

                $events[] = $newEvent;
            }

            return $events;
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

            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            $events = [];

            foreach ($result as $event) {
                $event_date = new DateTime($event['date']);
                $newEvent = new Event(
                    $event['title'],
                    $event_date,
                    $event['description']
                );
                $newEvent->setId($event['id']);

                if (!empty($event['event_address_id'])) {
                    $newEvent->setAddress($this->addressManager->getAddressById($event['event_address_id']));
                }

                $events[] = $newEvent;
            }

            return $events;
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

            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            $events = [];

            foreach ($result as $event) {
                $event_date = new DateTime($event['date']);
                $newEvent = new Event(
                    $event['title'],
                    $event_date,
                    $event['description']
                );
                $newEvent->setId($event['id']);

                if (!empty($event['event_address_id'])) {
                    $newEvent->setAddress($this->addressManager->getAddressById($event['event_address_id']));
                }

                $events[] = $newEvent;
            }

            return $events;
        }

        public function addEvent(Event $event) : Event {
            $query = $this->db->prepare('
                INSERT INTO events (title, date, description, event_address_id) 
                VALUES (:title, :date, :description, :event_address_id)
            ');
            $parameters = [
                'title' => $event->getTitle(),
                'date' => $event->getDate()->format('Y-m-d H:i:s'),
                'description' => $event->getDescription(),
                'event_address_id' => $event->getAddress()->getId()
            ];
            $query->execute($parameters);

            $event->setId($this->db->lastInsertId());

            return $event;
        }

        public function editEvent(Event $eventEdited) : Event {
            $rp = new ReflectionProperty('Event', 'address');

            if ($rp->isInitialized($eventEdited)) {
                $query = $this->db->prepare('
                    UPDATE events
                    SET title = :title, date = :date, description = :description, event_address_id = :event_address_id
                    WHERE id = :id
                ');
                $parameters = [
                    'id' => $eventEdited->getId(),
                    'title' => $eventEdited->getTitle(),
                    'date' => $eventEdited->getDate()->format('Y-m-d H:i:s'),
                    'description' => $eventEdited->getDescription(),
                    'event_address_id' => $eventEdited->getAddress()->getId()
                ];
            } else {
                $query = $this->db->prepare('
                    UPDATE events
                    SET title = :title, date = :date, description = :description
                    WHERE id = :id
                ');
                $parameters = [
                    'id' => $eventEdited->getId(),
                    'title' => $eventEdited->getTitle(),
                    'date' => $eventEdited->getDate()->format('Y-m-d H:i:s'),
                    'description' => $eventEdited->getDescription()
                ];
            }
            $query->execute($parameters);

            return $eventEdited;
        }

        public function getEventById (int $id) : Event {
            $query = $this->db->prepare('
                SELECT *
                FROM events
                WHERE id = :id
            ');
            $parameters = [
                'id' => $id
            ];
            $query->execute($parameters);

            $data = $query->fetch(PDO::FETCH_ASSOC);

            $event_date = new DateTime($data['date']);

            $newEvent = new Event (
                $data['title'],
                $event_date,
                $data['description']
            );

            if(!empty($data['event_address_id'])) {
                $address = $this->addressManager->getAddressById($data['event_address_id']);
                $newEvent->setAddress($address);
            }
            $newEvent->setId($data['id']);

            return $newEvent;
        }
    }
?>