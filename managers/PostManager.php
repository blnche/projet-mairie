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
            INSERT INTO posts (title, content, posted_status, created_date, posted_date, picture_id, parent_page_id)
            VALUES (:title, :content, :posted_status, :created_date, :posted_date, :picture_id, :parent_page_id)
            ');
            $parameters = [
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'posted_status' => $post->getStatus(),
                'created_date' => $post->getCreatedDate()->format('Y-m-d H:i:s'),
                'posted_date' => $post->getPostedDate() !== null ? $post->getPostedDate()->format('Y-m-d H:i:s') : null,
                'picture_id' => $post->getPicture() !== null ? $post->getPicture()->getId() : null,
                'parent_page_id' => $post->getParentPage() !== null ? $post->getParentPage()->getId() : null
            ];
            
            $query->execute($parameters);

            $post->setId($this->db->lastInsertId());

            return $post;
        }

        public function editPost(Post $postEdited) : Post
        {
            $query = $this->db->prepare('
            UPDATE posts
            SET title = :title, content = :content, posted_status = :posted_status, created_date = :created_date, posted_date = :posted_date, picture_id = :picture_id, parent_page_id = :parent_page_id
            WHERE id = :id
            ');
            $parameters = [
                'id' => $postEdited->getId(),
                'title' => $postEdited->getTitle(),
                'content' => $postEdited->getContent(),
                'posted_status' => $postEdited->getStatus(),
                'created_date' => $postEdited->getCreatedDate()->format('Y-m-d H:i:s'),
                'posted_date' => $postEdited->getPostedDate() !== null ? $postEdited->getPostedDate()->format('Y-m-d H:i:s') : null,
                'picture_id' => $postEdited->getPicture() !== null ? $postEdited->getPicture()->getId() : null,
                'parent_page_id' => $postEdited->getParentPage() !== null ? $postEdited->getParentPage()->getId() : null
            ];

            $query->execute($parameters);

            return $postEdited;
        }

        public function getAllPosts() : array
        {
            $query = $this->db->prepare('
                SELECT *
                FROM posts
            ');
            $query->execute();

            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            $posts = [];
            foreach($data as $post)
            {
                $postCreatedDate = new DateTime($post['created_date']);
                $newPost = new Post(
                    $post['title'],
                    $post['posted_status'],
                    $postCreatedDate
                );
                $newPost->setContent($post['content']);

                
                if ($post['parent_page_id'] === null) {
                    $newPost->setParentPage($post['parent_page_id']);
                } else {
                    $newPost->setParentPage($this->getPostById($post['parent_page_id']));
                }
                
                if ($post['posted_date'] === null) {
                    $newPost->setPostedDate($post['posted_date']);
                } else {
                    $newPost->setPostedDate(new DateTime($post['posted_date']));
                }
                
                if($post['picture_id'] === null) {
                    $newPost->setPicture($post['picture_id']);
                } else {
                    $newPost->setPicture($this->pictureManager->getPictureById($post['picture_id']));
                }
                $newPost->setId($post['id']);
                
                $posts[] = $newPost;
            }

            return $posts;
        }
        
        public function getPostById(int $postId) : Post 
        {
            $query = $this->db->prepare('
                SELECT *
                FROM posts
                WHERE id = :id
            ');
            $parameters = [
                'id' => $postId
            ];
            $query->execute($parameters);

            $data = $query->fetch(PDO::FETCH_ASSOC);
            $postCreatedDate = new DateTime($data['created_date']);
            
            $newPost = new Post(
                $data['title'],
                $data['posted_status'],
                $postCreatedDate
            );
            
            $newPost->setContent($data['content']);
            
            if ($data['parent_page_id'] === null) {
                $newPost->setParentPage($data['parent_page_id']);
            } else {
                $newPost->setParentPage($this->getPostById($data['parent_page_id']));
            }
            
            if ($data['posted_date'] === null) {
                $newPost->setPostedDate($data['posted_date']);
            } else {
                $newPost->setPostedDate(new DateTime($data['posted_date']));
            }
            var_dump($newPost->getPostedDate());
            
            if($data['picture_id'] === null) {
                $newPost->setPicture($data['picture_id']);
            } else {
                $newPost->setPicture($this->pictureManager->getPictureById($data['picture_id']));
            }
            $newPost->setId($data['id']);

            return $newPost;
        }

        public function getPostByName(string $postName) : Post
        {
            $query = $this->db->prepare('
                SELECT *
                FROM posts
                WHERE title = :title
            ');
            $parameters = [
                'title' => $postName
            ];
            $query->execute($parameters);

            $data = $query->fetch(PDO::FETCH_ASSOC);

            $postCreatedDate = new DateTime($data['created_date']);
            
            $newPost = new Post(
                $data['title'],
                $data['posted_status'],
                $postCreatedDate
            );
            
            $newPost->setContent($data['content']);

            if ($data['parent_page_id'] === null) {
                $newPost->setParentPage($data['parent_page_id']);
            } else {
                $newPost->setParentPage($this->getPostById($data['parent_page_id']));
            }
            
            if ($data['posted_date'] === null) {
                $newPost->setPostedDate($data['posted_date']);
            } else {
                $newPost->setPostedDate(new DateTime($data['posted_date']));
            }
            
            if($data['picture_id'] === null) {
                $newPost->setPicture($data['picture_id']);
            } else {
                $newPost->setPicture($this->pictureManager->getPictureById($data['picture_id']));
            }
            $newPost->setId($data['id']);

            return $newPost;
        }
    }
?>