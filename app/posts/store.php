<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called when new posts are stored/inserted into the database.

$errors = [];

if (isset($_FILES['post'])) {
    $post = $_FILES['post']; 
    if (!in_array($post['type'], ['image/jpeg', 'image/png'])) {
        $errors[] = 'The uploaded file type is not allowed.';
        $_SESSION['errors'] = $errors;
        redirect('/post.php');
    } elseif ($post['size'] > 2097152) {
        $errors[] = 'The uploaded file exceeds the 2MB filesize limit.';
        $_SESSION['errors'] = $errors;
        redirect('/post.php');
    };
    if (contains('-', $post['name']) || contains('.', $post['name'])) {
        $errors[] = 'Remove the characters "-" and "." from the image name you\'re trying to upload.';
        $_SESSION['errors'] = $errors;
        redirect('/post.php');
    };
    $user = $_SESSION['user'];
    $extension = explode('.', $post['name']);
    $date = date('Y-m-d H:i:s');
    if (isset($_POST['caption'])) {
        $caption = trim(filter_var($_POST['caption'],FILTER_SANITIZE_STRING));
    } else {
        $caption = "";
    };

    // Fetch all previously posted posts (to check how many there are)
    $queryFetchPosts = 'SELECT * FROM posts WHERE user_id = :user_id';
    $statement = $pdo->prepare($queryFetchPosts);
    $statement->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    // Define the pathname of the post (dependent on the number of previous posts posted)
    if(empty($posts)) {
        $postPath = $user['username'] . '-1.' . $extension[1]; // Define the path of the post for the first post by this user
    } else {
        for ($i = count($posts); $i >= count($posts); $i--) {
            $username = $user['username'];
            $lastPostExtension = explode('.', $posts[$i-1]['post_image']);
            $lastPostNumber = explode("$username-", $lastPostExtension[0]);
            $postNumber = $lastPostNumber[1] + 1;
        };
        $postPath = $user['username'] . '-' . $postNumber . '.' . $extension[1]; // Define the path of the post based on the number of previous posts.
    };
    
    // Save the post file
    move_uploaded_file($post['tmp_name'], __DIR__.'/../database/posts/'.$postPath);

    // Insert the post into the database
    $queryInsertPost = 'INSERT INTO posts (user_id, post_text, post_image, datetime) VALUES (:user_id, :post_text, :post_image, :datetime)';
    $statement = $pdo->prepare($queryInsertPost);
    $statement->execute([
        ':user_id' => $user['id'],
        ':post_text' => $caption,
        ':post_image' => $postPath,
        ':datetime' => $date
    ]);   
};

redirect('/home.php');