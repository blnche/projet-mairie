<?php
    class ChildManager extends AbstractManager
    {
        private UserManager $userManager;

        public function __construct()
        {
            parent::__construct();
            $this->userManager = new UserManager();
        }

        public function getChildById($id) : Child
        {
            $query = $this->db->prepare('
                SELECT * 
                FROM children
                WHERE id = :id
            ');
            $parameters = [
                'id' => $id
            ];
            $query->execute($parameters);

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $child = new Child(
                $result['firstName'],
                $result['lastName'],
                $result['age']
            );

            $child->setId($result['id']);
            $child->setParent($this->userManager->getUserById($result['parent_id']));

            return $child;
        }
        public function getChildrenByParentId($id) : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM children
                WHERE parent_id = :parent_id
            ');
            $parameters = [
                'parent_id' => $id
            ];
            $query->execute($parameters);

            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $children = [];

            foreach($result as $child)
            {
                $newChild = new Child(
                    $child['firstName'],
                    $child['lastName'],
                    $child['age']
                );
                $newChild->setId($child['id']);
                $newChild->setParent($this->userManager->getUserById($child['parent_id']));
                $children[] = $newChild;
            }

            return $children;
        }

        public function addChild(Child $child) : Child
        {
            $query = $this->db->prepare('
                INSERT INTO children (firstName, lastName, age, parent_id) 
                VALUES (:firstName, :lastName, :age, :parent_id)                                              
            ');
            $parameters = [
                'firstName' => $child->getFirstName(),
                'lastName' => $child->getLastName(),
                'age' => $child->getAge(),
                'parent_id' => $child->getParent()->getId()
            ];
            $query->execute($parameters);

            $child->setId($this->db->lastInsertId());

            return $child;
        }
    }
?>