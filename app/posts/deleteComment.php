<?php 

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if(!isset($_SESSION['user'])) {
    redirect('/');
}

// Get post information
if(isset($_GET['comment_id'])){

    $commentId = $_GET['comment_id'];
    
    $statement = $pdo->prepare('DELETE FROM comments WHERE comment_id = :comment_id');

    $statement->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
    
    $statement->execute();

    $successes[] = "Your comment was deleted";
    $_SESSION['successes'] = $successes;
    redirect("/../../feed.php");
    exit;
}


