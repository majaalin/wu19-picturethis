<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we delete the selected post from the database and users profile and return home.

if(isset($_POST['post-id'])) {
    $postID = $_POST['post-id'];

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
}

redirect('/home.php');