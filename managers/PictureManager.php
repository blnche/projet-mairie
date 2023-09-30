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
    }
?>