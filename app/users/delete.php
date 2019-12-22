<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we logout a user and delete an account.
$email = $_SESSION['user']['email'];

$queryDelete = sprintf("DELETE FROM users WHERE email = :email");
$statement = $pdo->prepare($queryDelete);
$statement->bindParam(':email', $email, PDO::PARAM_STR);
$statement->execute();

// DELETE ALL POSTS AND COMMENTS

unset($_SESSION['user']);
redirect('/');