<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we logout a user and delete an account.
$id = intval($_SESSION['user']['id']);
var_dump($id);

// Delete user
$queryDeleteUser = sprintf("DELETE FROM users WHERE id = :id");
$statement = $pdo->prepare($queryDeleteUser);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();

// Delete posts
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
    unlink(__DIR__.'/app/database/avatars/'.$_SESSION['avatar']);
    unset($_SESSION['avatar']);
}

unset($_SESSION['user']);
redirect('/');