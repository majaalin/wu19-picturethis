<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we delete posts in the database.

header('Content-Type: application/json');

if(isset($_POST['post-id'],$_POST['post-text'])) {
    $postID = trim(filter_var($_POST['post-id'],FILTER_SANITIZE_NUMBER_INT));
    $newPostText = trim(filter_var($_POST['post-text'],FILTER_SANITIZE_STRING));

    $queryUpdatePostText = 'UPDATE posts SET post_text = :post_text WHERE post_id = :post_id';
    $statement = $pdo->prepare($queryUpdatePostText);
    $statement->execute([
        ':post_id' => $postID,
        ':post_text' => $newPostText
    ]);

    $post = [
        'postID' => $postID,
        'postText' => $newPostText,
    ];
    $post = json_encode($post);
    echo $post;
}