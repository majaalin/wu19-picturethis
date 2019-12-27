<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we logout a user and delete an account.
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
    var_dump($postPath);
    unlink(__DIR__.'/../database/posts/'.$postPath);
}

$queryDeletePosts = sprintf("DELETE FROM posts WHERE user_id = :user_id");
$statement = $pdo->prepare($queryDeletePosts);
$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
$statement->execute();

// Delete avatar
if($_SESSION['avatar']) {
    $queryDeleteAvatar = sprintf("DELETE FROM avatars WHERE avatar_id = :avatar_id");
    $statement = $pdo->prepare($queryDeleteAvatar);
    $statement->bindParam(':avatar_id', $id, PDO::PARAM_INT);
    $statement->execute();
    unlink(__DIR__.'/../database/avatars/'.$_SESSION['avatar']);
    var_dump($_SESSION['avatar']);
    unset($_SESSION['avatar']);
}
// die(var_dump($id));
unset($_SESSION['user']);
redirect('/');