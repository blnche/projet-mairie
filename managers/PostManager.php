<?php 
//editPost
//addPost
//getPostById
//getAllPosts
    class PostManager extends AbstractManager
    {
        private PictureManager $pictureManager;
        public function __construct()
        {
            parent::__construct();
            $this->pictureManager = new PictureManager();
        }

        public function addPost(Post $post) : Post
        {
            $query = $this->db->prepare('
                INSERT INTO posts (title, content, posted_status, created_date, posted_date, picture_id)
                VALUES (:title, :content, :posted_status, :created_date, :posted_date, :picture_id)
            ');
            $parameters = [
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'posted_status' => $post->getStatus(),
                'created_date' => $post->getCreatedDate()->format('Y-m-d H:i:s'),
                'posted_date' => $post->getPostedDate()->format('Y-m-d H:i:s'),
                'picture_id' => $post->getPicture()->getId()
            ];
            
            $query->execute($parameters);

            $post->setId($this->db->lastInsertId());

            return $post;
        }

        public function editAssociation(Association $associationEdited) : Association
        {
            $query = $this->db->prepare('
                UPDATE associations
                SET name = :name, president_firstName = :presidentFirstName, president_lastName = :presidentLastName, status = :status
                WHERE id = :id
            ');
            $parameters = [
                'id' => $associationEdited->getId(),
                'name' => $associationEdited->getName(),
                'presidentFirstName' => $associationEdited->getPresidentFirstName(),
                'presidentLastName' => $associationEdited->getPresidentLastName(),
                'status' => $associationEdited->getStatus(),
                'assoc_address_id' => $associationEdited->getAddress()->getId()
            ];
            $query->execute($parameters);

            return $associationEdited;
        }

        public function getAllAssociations() : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM associations
            ');
            $query->execute();

            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            $associations = [];
            foreach($data as $association)
            {
                $newAssociation = new Association(
                    $association['name'],
                    $association['president_firstName'],
                    $association['president_lastName'],
                    $association['status']
                );
                $newAssociation->setAddress($this->addressManager->getAddressById($association['assoc_address_id']));
                $newAssociation->setId($association['id']);
                $associations[] = $newAssociation;
            }

            return $associations;
        }

        public function getAssociationById($id) : Association
        {
            $query = $this->db->prepare('
                SELECT *
                FROM associations
                WHERE id = :id
            ');
            $parameters = [
                'id' => $id
            ];
            $query->execute($parameters);

            $data = $query->fetch(PDO::FETCH_ASSOC);

            $newAssociation = new Association(
                $data['name'],
                $data['president_firstName'],
                $data['president_lastName'],
                $data['status']
            );
            $address = $this->addressManager->getAddressById($data['assoc_address_id']);
            $newAssociation->setAddress($address);
            $newAssociation->setId($data['id']);

            return $newAssociation;
        }
    }
?>