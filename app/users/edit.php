<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we edit user data.
$oldUsername = $_SESSION['user']['username'];
$oldBio = $_SESSION['user']['bio'];
$id = $_SESSION['user']['id'];

if(isset($_POST['username'],$_POST['bio'])) {
    if($_POST['username']!=='') {
        $newUsername = trim(filter_var($_POST['username'],FILTER_SANITIZE_STRING));
    } else {
        $newUsername = $oldUsername;
    }
    if($_POST['bio']!=='') {
        $newBio = trim(filter_var($_POST['bio'], FILTER_SANITIZE_STRING));
    } else {
        $newBio = $oldBio;
    }
    $queryUpdate = 'UPDATE users SET username = :username, bio = :bio WHERE id = :id';
    $statement = $pdo->prepare($queryUpdate);
    $statement->execute([
        ':username' => $newUsername,
        ':bio' => $newBio,
        ':id' => $id
    ]);
}
    
if($_SESSION['avatar']) {
    $image = $_SESSION['avatar'];

    if($newUsername) {
    
        $queryFetchAvatars = 'SELECT * FROM avatars WHERE username = :username';
        $statement = $pdo->prepare($queryFetchAvatars);
        $statement->bindParam(':username', $oldUsername, PDO::PARAM_STR);
        $statement->execute();
        $avatar = $statement->fetch(PDO::FETCH_ASSOC);
        
        if($avatar===false) {
            $queryInsertAvatar = 'INSERT INTO avatars (avatar_id, username, image) VALUES (:avatar_id, :username, :image)';
            $statement = $pdo->prepare($queryInsertAvatar);
            $statement->execute([
                ':avatar_id' => $id,
                ':username' => $newUsername,
                ':image' => $image
            ]);
        } else {
            $queryUpdateAvatar = 'UPDATE avatars SET username = :username, image = :image WHERE avatar_id = :id';
            $statement = $pdo->prepare($queryUpdateAvatar);
            $statement->execute([
                ':id' => $id,
                ':username' => $newUsername,
                ':image' => $image
            ]);
        }
    }
}

$_SESSION['user']['username'] = $newUsername;
$_SESSION['user']['bio'] = $newBio;
redirect('/');