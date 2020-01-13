<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called whenever a comment is entered into the database.

header('Content-Type: application/json');

if(isset($_POST['post-id'],$_POST['comment-text'])) {
    $commentText = trim(filter_var($_POST['comment-text'], FILTER_SANITIZE_STRING));
    $queryInsertComment = 'INSERT INTO comments (post_id, user_id, username, comment_text) VALUES (:post_id, :user_id, :username, :comment_text)';
    $statement = $pdo->prepare($queryInsertComment);
    $statement->execute([
        ':post_id' => $_POST['post-id'],
        ':user_id' => $_SESSION['user']['id'],
        ':username' => $_SESSION['user']['username'],
        ':comment_text' => $commentText
    ]);
    $comment = [
        'commentText' => $commentText,
    ];
    $comment = json_encode($comment);
    echo $comment;
};