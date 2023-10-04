<?php 
    class PictureManager extends AbstractManager
    {
        public function addPicture(Picture $picture) : Picture 
        {
            $query = $this->db->prepare('
                INSERT INTO pictures (title, url)
                VALUES (:title, :url)
            ');
            $parameters = [
                'title' => $picture->getTitle(),
                'url' => $picture->getUrl()
            ];
            $query->execute($parameters);

            $picture->setId($this->db->lastInsertId());

            return $picture;
        }
        
        public function getPictureById(int $pictureId) : Picture
        {
            $query = $this->db->prepare('
            SELECT *
            FROM pictures
            WHERE id = :id
            ');
            $parameters = [
                'id' => $pictureId
            ];
            
            $query->execute($parameters);
            
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            $picture = new Picture (
                $result['title'],
                $result['url']
            );
                
            $picture->setId($result['id']);
                
            return $picture;
        }
    }
?>