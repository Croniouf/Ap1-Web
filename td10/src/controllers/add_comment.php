<?php

require_once('src/model.php');

function addComment($identifier, $input)
{
    $author = null;
    $comment = null;
    
    if (!empty($input['author'])) {
        $author = $input['author'];
    }
    
    if (!empty($input['comment'])) {
        $comment = $input['comment'];
    }
    
    if (!$author || !$comment) {
        die('Tous les champs doivent être remplis');
    }
    
    $success = createComment($identifier, $author, $comment);
    
    if (!$success) {
        die('Impossible d\'ajouter le commentaire !');
    } else {
        // Redirection vers le post après ajout du commentaire
        header('Location: index.php?action=post&id=' . $identifier);
        exit();
    }
}

?>