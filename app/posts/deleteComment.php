<?php 

declare(strict_types=1);

require __DIR__.'/../autoload.php';

header('Content-Type: application/json');

// Get post information
if(isset($_POST['comment_id'])){

    $commentId = $_POST['comment_id'];
    
    $statement = $pdo->prepare('DELETE FROM comments WHERE comment_id = :comment_id');

    $statement->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
    
    $statement->execute();

    echo json_encode($commentId);
}

redirect("/../../feed.php");


