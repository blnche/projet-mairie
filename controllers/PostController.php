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
        $this->render('views/admin/articles/posts/posts.phtml', ['posts' => $posts], 'Articles', 'admin');
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
            if(!empty($_POST['content']))
            {
                $content = htmlspecialchars($_POST['content']);
                $post->setContent($content);
            }
            
            // Check for status
            if($status === 'published') {
                $postedDate = new DateTime();
                
                $post->setPostedDate($postedDate);
            }
            
            // Check for picture
            if(!empty($_POST['picture-title'])) {
                //Create new Picture
                $picture = $_FILES['image'];
    
                $picture_title = htmlspecialchars($picture['name']);
    
                $path = 'data/pictures/'.$picture_title;
    
                move_uploaded_file($picture['tmp_name'], $path);
    
                $newPicture = new Picture($picture_title, $path);
    
                $this->pictureManager->addPicture($newPicture);
    
                $post->setPicture($newPicture);
            }
            
            // Check for parent page
            if(!empty($_POST['parent-page-id'])) 
            {
                $parentPage = $this->postManager->getPostById(htmlspecialchars($_POST['parent-page-id']));
                
                $post->setParentPage($parentPage);
            }
            
            var_dump($post);
            
            
            $this->postManager->addPost($post);
            
            header('Location:/projet-final/projet-mairie/admin/articles');
        }
        else
        {
            $this->render('views/admin/articles/_form-add-post.phtml', [], 'Ajouter une page', 'admin');
        }
    }
    
    public function editPost(int $postId) : void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifyPost']))
        {
            $rpParentPage = new ReflectionProperty('Post', 'parentPage');
            $rpContent = new ReflectionProperty('Post', 'content');
            $rpPicture = new ReflectionProperty('Post', 'picture');

            $postCurrentInformations = $this->postManager->getPostById($postId);

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
                
                if($status === 'published') {
                    $postedDate = new DateTime();
                } else if ($status === 'draft') {
                    $postedDate = null;
                }
            }
            else {
                $status = $postCurrentInformations->getStatus();
            }
            

            $postUpdated = new Post(
                $title,
                $content,
                $status,
                $createdDate
            );
            $postUpdated->setId($postCurrentInformations->getId());

            // Check if object has parent page
            if ($rp->isInitialized($postCurrentInformations))
            {
                $postCurrentParentPage = $postCurrentInformations->getParentPage();

                if (!empty($_POST['parent-page-id']))
                {
                    $parentPage = $this->postManager->getPostById(htmlspecialchars($_POST['parent-page-id']));
                }
                else {
                    $parentPage = $postCurrentParentPage;
                }
    
                    $postUpdated->setParentPage($parentPage);
            }
            
            // Check if object has picture
            if ($rpPicture->isInitialized($postCurrentInformations)) 
            {
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
                
                $postUpdated->setParentPage($picture);
            }
            
            // Check if object has content
            if ($rpContent->isInitialized($postCurrentInformations))
            {
                $postCurrentContent = $postCurrentInformations->getContent();
                
                if(!empty($_POST['content'])) 
                {
                    $content = htmlspecialchars($_POST['content']);
                }
                else {
                    $content = $postCurrentContent;
                }
                
                $postUpdated->setParentPage($content);
            }
            
            $this->postManager->editPost($postUpdated);
            
            header('Location:/projet-final/projet-mairie/admin/articles');
        }
        else
        {
            $this->render('views/admin/articles/_form-modify-post.phtml', [], 'Modifier une page', 'admin');
        }
    }
}
?>