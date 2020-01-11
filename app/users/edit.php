<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called when a user's username, email and bio are changed.

$errors = [];

$oldEmail = $_SESSION['user']['email'];
$oldUsername = $_SESSION['user']['username'];
$oldBio = $_SESSION['user']['bio'];
$id = $_SESSION['user']['id'];

if(isset($_POST['email'],$_POST['username'],$_POST['bio'])) {
    if($_POST['email']!=='') {
        $newEmail = trim(filter_var($_POST['email'],FILTER_SANITIZE_EMAIL));
    } else {
        $newEmail = $oldEmail;
    };
    if($_POST['username']!=='') {
        $newUsername = trim(filter_var($_POST['username'],FILTER_SANITIZE_STRING));
    } else {
        $newUsername = $oldUsername;
    };
    if($_POST['bio']!=='') {
        $newBio = trim(filter_var($_POST['bio'], FILTER_SANITIZE_STRING));
    } else {
        $newBio = $oldBio;
    };

    // Check username and email don't already exist.
    $queryFetchUser = 'SELECT * FROM users WHERE username = :username';
    $statement = $pdo->prepare($queryFetchUser);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $usernameExists = $statement->fetch(PDO::FETCH_ASSOC);

    $queryFetchEmail = 'SELECT * FROM users WHERE email = :email';
    $statement = $pdo->prepare($queryFetchEmail);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $emailExists = $statement->fetch(PDO::FETCH_ASSOC);
    
    if ($usernameExists && $emailExists) {
        $errors[] = 'The username and email you\'ve entered are both already being used. Do you perhaps already have an account?';
        $_SESSION['errors'] = $errors;
        redirect('/edit.php');
    } elseif ($usernameExists) {
        $errors[] = 'The username you\'ve selected is already taken. What else could you imagine calling yourself?';
        $_SESSION['errors'] = $errors;
        redirect('/edit.php');
    } elseif ($emailExists) {
        $errors[] = 'The email you\'ve entered is already taken. Do you perhaps already have an account?';
        $_SESSION['errors'] = $errors;
        redirect('/edit.php');
    };

    $queryUpdate = 'UPDATE users SET email = :email, username = :username, bio = :bio WHERE id = :id';
    $statement = $pdo->prepare($queryUpdate);
    $statement->execute([
        ':email' => $newEmail,
        ':username' => $newUsername,
        ':bio' => $newBio,
        ':id' => $id
    ]);
    
    if($newUsername) {
        // Fetch all posts uploaded by the user
        $queryFetchPosts = 'SELECT * FROM posts WHERE user_id = :user_id';
        $statement = $pdo->prepare($queryFetchPosts);
        $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
        // Change the name of all post .jpg & .png files (if the user has posted)
        foreach ($posts as $post) {
            $oldImage = $post['post_image'];
            $postId = $post['post_id'];
            $oldNumExtension = str_replace($oldUsername, "", $oldImage);
            $tempArray = [$newUsername, $oldNumExtension];
            $newImage = implode("",$tempArray);
            $queryUpdatePost = 'UPDATE posts SET post_image = :new_image WHERE post_id = :post_id';
            $statement = $pdo->prepare($queryUpdatePost);
            $statement->execute([
                ':post_id' => $postId,
                ':new_image' => $newImage
            ]);
            rename('../database/posts/'.$oldImage,'../database/posts/'.$newImage);
        };

        // Check (and fetch) to see if the user has uploaded an avatar.
        $queryFetchAvatars = 'SELECT * FROM avatars WHERE username = :username';
        $statement = $pdo->prepare($queryFetchAvatars);
        $statement->bindParam(':username', $oldUsername, PDO::PARAM_STR);
        $statement->execute();
        $avatar = $statement->fetch(PDO::FETCH_ASSOC);
        // Change the name of the avatar .jpg or .png file (if the user has uploaded one).
        if($avatar!==false) {
            $extension = explode('.',$_SESSION['avatar']);
            $image = $newUsername . '.' . $extension[1];
            $queryUpdateAvatar = 'UPDATE avatars SET username = :username, image = :image WHERE avatar_id = :id';
            $statement = $pdo->prepare($queryUpdateAvatar);
            $statement->execute([
                ':id' => $id,
                ':username' => $newUsername,
                ':image' => $image
            ]);
            rename('../database/avatars/'.$_SESSION['avatar'],'../database/avatars/'.$image);
            $_SESSION['avatar'] = $image;
        };
    };
};

$_SESSION['user']['email'] = $newEmail;
$_SESSION['user']['username'] = $newUsername;
$_SESSION['user']['bio'] = $newBio;
redirect('/home.php');