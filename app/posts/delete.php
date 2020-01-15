<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called when a selected post is deleted from a user's profile & the database.

if(isset($_POST['post-id'])) {
    $postID = intval(filter_var($_POST['post-id'],FILTER_SANITIZE_NUMBER_INT));

    // Fetch and delete image from database
    $queryFetchPost = sprintf('SELECT * FROM posts WHERE post_id = :post_id');
    $statement = $pdo->prepare($queryFetchPost);
    $statement->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $statement->execute();
    $post = $statement->fetch(PDO::FETCH_ASSOC);

    $postPath = $post['post_image'];
    unlink(__DIR__.'/../database/posts/'.$postPath);

    // Delete post
    $queryDeletePost = sprintf('DELETE FROM posts WHERE post_id = :post_id');
    $statement = $pdo->prepare($queryDeletePost);
    $statement->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $statement->execute();

    // Delete likes associated with post
    $queryDeleteLikes = sprintf('DELETE FROM likes WHERE post_id = :post_id');
    $statement = $pdo->prepare($queryDeleteLikes);
    $statement->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $statement->execute();

    // Delete comments associated with post
    $queryDeleteComments = sprintf('DELETE FROM comments WHERE post_id = :post_id');
    $statement = $pdo->prepare($queryDeleteComments);
    $statement->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $statement->execute();
}

redirect('/home.php');