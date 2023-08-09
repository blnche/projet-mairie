<?php 

    if (isset($_GET['route']))
    {
        $route = $_GET['route'];
        if($route === 'back-office')
        {
            require './views/admin/dashboard.phtml';
        }
        else if ($route === 'mairie')
        {
            require './views/public/mairie/mairie.phtml';
        }
        else if ($route === 'projets')
        {
            require './views/public/projets/projets.phtml';
        }
        else if ($route === 'pratique')
        {
            require './views/public/pratique/pratique.phtml';
        }
        else if ($route === 'vivre')
        {
            require './views/public/vivre/vivre.phtml';
        }
        else if ($route === 'decouvrir')
        {
            require './views/public/decouvrir/decouvrir.phtml';
        }
        else if ($route === 'espace-famille')
        {
            require './views/user/dashboard.phtml';
        }
    }
    else
    {
        require './views/layout.phtml';
    }
?>