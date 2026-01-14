<?php
function dbConnect()
{
    // Connexion à la base de données
    try
    {
        $database = new PDO('mysql:host=localhost;dbname=td10_;charset=utf8', 'root', 'root');
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $database;
    }
    catch(Exception $e)
    {
        die('Erreur de connexion : '.$e->getMessage());
    }
}

function getPosts()
{
    $database = dbConnect();
    
    // On récupère les 5 derniers billets
    $statement = $database->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM posts ORDER BY creation_date DESC LIMIT 0, 5');
    
    $posts = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $posts[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'french_creation_date' => $row['date_creation_fr'],
            'content' => $row['content']
        ];
    }
    $statement->closeCursor();
    
    return $posts;
}

function getPost($id)
{
    $database = dbConnect();
    
    // Validation de l'ID
    if (!is_numeric($id) || $id <= 0) {
        return null;
    }
    
    $statement = $database->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM posts WHERE id = ?');
    $statement->execute([$id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    
    if (!$row) {
        return null;
    }
    
    $post = [
        'identifier' => $row['id'],
        'title' => $row['title'],
        'french_creation_date' => $row['date_creation_fr'],
        'content' => $row['content']
    ];
    
    $statement->closeCursor();
    
    return $post;
}

function getComments($id)
{
    $database = dbConnect();
    
    // Validation de l'ID
    if (!is_numeric($id) || $id <= 0) {
        return [];
    }
    
    $statement = $database->prepare("SELECT comments.id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, user.email AS author_email FROM comments JOIN user ON comments.author = user.id WHERE post_id = ? ORDER BY comment_date DESC");
    $statement->execute([$id]);
    
    $comments = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $comments[] = [
            'author' => $row['author'],
            'author_email' => $row['author_email'],
            'french_creation_date' => $row['french_creation_date'],
            'comment' => $row['comment'],
        ];
    }
    $statement->closeCursor();
    
    return $comments;
}

function createComment($postId, $author, $comment)
{
    // Validation des entrées
    if (!is_numeric($postId) || $postId <= 0) {
        return false;
    }
    
    $author = trim($author);
    $comment = trim($comment);
    
    if (empty($author) || empty($comment)) {
        return false;
    }
    
    // Si un user est connecté via session
    session_start();
    if (isset($_SESSION['user_id'])) {
        $authorId = $_SESSION['user_id'];
        // Utiliser l'ID utilisateur si disponible
        $author = $authorId;
    }
    
    $database = dbConnect();
    
    // Échapper les données pour sécurité
    $author = htmlspecialchars($author, ENT_QUOTES, 'UTF-8');
    $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
    
    $statement = $database->prepare(
        'INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())');
    
    $affectedLines = $statement->execute([$postId, $author, $comment]);
    
    return ($affectedLines > 0);
}
?>