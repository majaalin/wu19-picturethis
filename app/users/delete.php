<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we logout a user and delete an account.
$username = $_SESSION['user']['username'];
var_dump($username);

$queryDelete = sprintf("DELETE FROM users WHERE username = :username");
$statement = $pdo->prepare($queryDelete);
$statement->bindParam(':username', $username, PDO::PARAM_STR);
$statement->execute();

if($_SESSION['avatar']) {
    $queryDelete = sprintf("DELETE FROM avatars WHERE username = :username");
    $statement = $pdo->prepare($queryDelete);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    unlink(__DIR__.'/app/database/avatars/'.$_SESSION['avatar']);
    unset($_SESSION['avatar']);
}

// DELETE ALL POSTS AND COMMENTS

unset($_SESSION['user']);
redirect('/');