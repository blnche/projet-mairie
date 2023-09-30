<?php 
class PostController extends AbstractController
{
    private EventManager $eventManager;
    private PictureManager $pictureManager;
    private PostManager $postManager;


    public function __construct()
    {
        $this->eventManager = new EventManager();
        $this->pictureManager = new PictureManager();
        $this->postManager = new PostManager();
    }
    
    public function posts() : void 
    {
        $posts = $this->postManager->getAllPosts();
        $this->render('views/admin/articles/posts.phtml', ['posts' => $posts], 'Articles', 'admin');
    }
    
    public function addPost() : void 
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerPost']))
        {
            // Create new Post
            $title = htmlspecialchars($_POST['title']);
            $status = htmlspecialchars($_POST['status']);
            $createdDate = new DateTime();
            
            $post = new Post(
                $title,
                $status,
                $createdDate
            );
            
            // Check for content
            if(!empty($_POST['content'])) {
                $content = htmlspecialchars($_POST['content']);
            } else {
                $content = null;
            }
            $post->setContent($content);
            
            // Check for status
            if($status === 'published') {
                $postedDate = new DateTime();
            } else {
                $postedDate = null;
            }
            $post->setPostedDate($postedDate);
            
            // Check for picture
            if(!empty($_POST['picture-title'])) {
                //Create new Picture
                $picture = $_FILES['image'];
    
                $picture_title = htmlspecialchars($picture['name']);
    
                $path = 'data/pictures/'.$picture_title;
    
                move_uploaded_file($picture['tmp_name'], $path);
    
                $picture = new Picture($picture_title, $path);
    
                $this->pictureManager->addPicture($picture);
    
            } else {
                $picture = null;
            }
            $post->setPicture($picture);
            
            // Check for parent page
            if(!empty($_POST['parent-page-id'])) {
                $parentPage = $this->postManager->getPostById(htmlspecialchars($_POST['parent-page-id']));
            } else {
                $parentPage = null;
            }
            $post->setParentPage($parentPage);
            
            var_dump($post);
            
            
            $this->postManager->addPost($post);
            
            header('Location:/projet-final/projet-mairie/admin/articles');
        }
        else
        {
            $this->render('views/admin/articles/_form-add-post.phtml', [], 'Ajouter une page', 'admin');
        }
    }
    
    public function modifyPost(int $postId) : void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifyPage']))
        {
            $postCurrentInformations = $this->postManager->getPostById($postId);
            
            $createdDate = $postCurrentInformations->getCreatedDate();

            if (!empty($_POST['title']))
            {
                $title = htmlspecialchars($_POST['title']);
            }
            else {
                $title = $postCurrentInformations->getTitle();
            }
            

            if (!empty($_POST['status']))
            {
                $status = htmlspecialchars($_POST['status']);
            }
            else {
                $status = $postCurrentInformations->getStatus();
            }
            
            $postUpdated = new Post(
                $title,
                $status,
                $createdDate
            );
            $postUpdated->setId($postCurrentInformations->getId());
            
            // Check for status
            if($postUpdated->getStatus() === 'published') {
                if (!empty($_POST['status'])) {
                    $postedDate = new DateTime();
                } else {
                    $postedDate = $postCurrentInformations->getPostedDate();
                }
            } else if ($postUpdated->getStatus() === 'draft') {
                $postedDate = null;
            }
            
            // Check for parent page
            $postCurrentParentPage = $postCurrentInformations->getParentPage();
            if (!empty($_POST['parent-page-id']))
            {
                $parentPage = $this->postManager->getPostById(htmlspecialchars($_POST['parent-page-id']));
            die;
            }
            else {
                $parentPage = $postCurrentParentPage;
            }
            $postUpdated->setParentPage($parentPage);

            // Check for picture
            $postCurrentPicture = $postCurrentInformations->getPicture();
            if(!empty($_POST['picture-title'])) 
            {
                //Create new Picture
                $picture = $_FILES['image'];
    
                $picture_title = htmlspecialchars($picture['name']);
    
                $path = 'data/pictures/'.$picture_title;
    
                move_uploaded_file($picture['tmp_name'], $path);
    
                $picture = new Picture($picture_title, $path);
    
                $this->pictureManager->addPicture($picture);
            }
            else {
                $picture = $postCurrentPicture;
            }
            $postUpdated->setPicture($picture);
            
            // Check for content
            $postCurrentContent = $postCurrentInformations->getContent();
            if(!empty($_POST['content'])) 
            {
                $content = htmlspecialchars($_POST['content']);
            }
            else {
                $content = $postCurrentContent;
            }
            $postUpdated->setContent($content);
            
            $this->postManager->editPost($postUpdated);
            
            header('Location:/projet-final/projet-mairie/admin/articles');
        }
        else
        {
            $this->render('views/admin/articles/_form-modify-post.phtml', [], 'Modifier une page', 'admin');
        }
    }
    
    //for public
    
    public function readPost (string $postName) : void 
    {
        $post = $this->postManager->getPostByName($postName);
        $postTitle = $post->getTitle();
        $postContent = $post->getContent();
        $postPicture = $post->getPicture();
        
        $this->render('views/public/_post.phtml', ['content' => $postContent, 'picture' => $postPicture], $postTitle);
    }
}
?>