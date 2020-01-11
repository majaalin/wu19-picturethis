<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we update the likes database with a new like.

header('Content-Type: application/json');

if(isset($_POST['followed-user-id'])) {

    $queryInsertFollower = 'INSERT INTO follows (user_id, id_following) VALUES (:user_id, :id_following)';
    $statement = $pdo->prepare($queryInsertFollower);
    $statement->execute([
        ':user_id' => $_SESSION["user"]["id"],
        ':id_following' => $_POST['followed-user-id']
    ]);
    
};