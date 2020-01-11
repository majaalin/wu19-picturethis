<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called whenever a post is unliked. Each unlike is removed from the database.

header('Content-Type: application/json');

if(isset($_POST['post-id'],$_POST['liked-user-id'])) {
    $queryDeleteLike = 'DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id';
    $statement = $pdo->prepare($queryDeleteLike);
    $statement->execute([
        ':post_id' => $_POST['post-id'],
        ':user_id' => $_SESSION['user']['id']
    ]); 
};