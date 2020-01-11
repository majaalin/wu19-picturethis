<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called whenever a post is liked. Each like is entered into the database.

header('Content-Type: application/json');

if(isset($_POST['post-id'],$_POST['liked-user-id'])) {
    $queryInsertPost = 'INSERT INTO likes (post_id, user_id, liked_user_id) VALUES (:post_id, :user_id, :liked_user_id)';
    $statement = $pdo->prepare($queryInsertPost);
    $statement->execute([
        ':post_id' => $_POST['post-id'],
        ':user_id' => $_SESSION["user"]["id"],
        ':liked_user_id' => $_POST['liked-user-id']
    ]);
};