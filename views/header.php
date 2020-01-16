<?php
// Load the default application setup.
require __DIR__.'/../app/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $config['title']; ?></title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/fonts.css">
    <link rel="stylesheet" href="/assets/styles/nav.css">
    <?php require __DIR__."/../assets/styles/body.php"; ?>
    <?php if($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/index.php') : 
    require __DIR__."/../assets/styles/index.php";
    endif; ?>
    <?php if($_SERVER['REQUEST_URI'] === '/login.php' || $_SERVER['REQUEST_URI'] === '/post.php' || $_SERVER['REQUEST_URI'] === '/activity.php' || $_SERVER['REQUEST_URI'] === '/edit.php?') : ?>
    <link rel="stylesheet" href="/assets/styles/login.css">
    <?php endif; ?>
    <?php if($_SERVER['REQUEST_URI'] === '/search.php') : 
        if(isset($_SESSION['profileID'])) :
            $posts = getPostsByUser($_SESSION['profileID'],$pdo);
        else :
            $posts = getAllPosts($pdo);
        endif;
        if(count($posts)<2) : ?>
        <link rel="stylesheet" href="/assets/styles/login.css">
        <?php endif; ?>
    <?php endif; ?>
    <?php if($_SERVER['REQUEST_URI'] === '/feed.php') : 
        if(isset($_SESSION['profileID'])) :
            $posts = getPostsByUser($_SESSION['profileID'],$pdo);
        else :
            $posts = getPostsByFollowings($_SESSION['user']['id'],$pdo);
        endif;
        if(count($posts)<2) : ?>
        <link rel="stylesheet" href="/assets/styles/login.css">
        <?php endif; ?>
    <?php endif; ?>
    <?php if($_SERVER['REQUEST_URI'] === '/home.php') : 
        $posts = getPostsByUser($_SESSION['user']['id'],$pdo); 
        if(count($posts)<2) : ?>
        <link rel="stylesheet" href="/assets/styles/login.css">
        <?php endif; ?>
    <?php endif; ?>

</head>

<body>
