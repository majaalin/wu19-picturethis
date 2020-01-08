<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we delete posts in the database.

if(isset($_POST['post-id'],$_POST['return-url'],$_POST['post-text'])) {
    $postID = $_POST['post-id'];
    $newPostText = $_POST['post-text'];

    $queryUpdatePostText = 'UPDATE posts SET post_text = :post_text WHERE post_id = :post_id';
    $statement = $pdo->prepare($queryUpdatePostText);
    $statement->execute([
        ':post_id' => $postID,
        ':post_text' => $newPostText
    ]);
}

$returnMap = $_POST['return-url'];
redirect("$returnMap");