<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called when a user's account is deleted.

$id = intval($_SESSION['user']['id']);

// Delete user
$queryDeleteUser = sprintf("DELETE FROM users WHERE id = :id");
$statement = $pdo->prepare($queryDeleteUser);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();

// Delete posts
$queryFetchPosts = 'SELECT * FROM posts WHERE user_id = :user_id';
$statement = $pdo->prepare($queryFetchPosts);
$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $post) {
    $postPath = $post['post_image'];
    unlink(__DIR__.'/../database/posts/'.$postPath);
};

$queryDeletePosts = sprintf("DELETE FROM posts WHERE user_id = :user_id");
$statement = $pdo->prepare($queryDeletePosts);
$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
$statement->execute();

// Delete likes
$queryDeleteLikes = sprintf("DELETE FROM likes WHERE user_id = :user_id");
$statement = $pdo->prepare($queryDeleteLikes);
$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
$statement->execute();

// Delete follows
$queryDeleteFollows = sprintf("DELETE FROM follows WHERE user_id = :user_id OR id_following = :user_id");
$statement = $pdo->prepare($queryDeleteFollows);
$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
$statement->execute();

// Delete comments 
$queryDeleteComments = sprintf('DELETE FROM comments WHERE user_id = :user_id');
$statement = $pdo->prepare($queryDeleteComments);
$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
$statement->execute();

// Delete avatar
if($_SESSION['avatar']) {
    $queryDeleteAvatar = sprintf("DELETE FROM avatars WHERE avatar_id = :avatar_id");
    $statement = $pdo->prepare($queryDeleteAvatar);
    $statement->bindParam(':avatar_id', $id, PDO::PARAM_INT);
    $statement->execute();
    unlink(__DIR__.'/../database/avatars/'.$_SESSION['avatar']);
    unset($_SESSION['avatar']);
};

unset($_SESSION['user']);
redirect('/');