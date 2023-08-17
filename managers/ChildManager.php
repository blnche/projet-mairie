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
    }
?>