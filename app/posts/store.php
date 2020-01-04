<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we store/insert new posts in the database.
$errors = [];

if (isset($_FILES['post'])) {
    $post = $_FILES['post']; 
    if (!in_array($post['type'], ['image/jpeg', 'image/png'])) {
        $errors[] = 'The uploaded file type is not allowed.';
        redirect('/post.php');
    } elseif ($post['size'] > 2097152) {
        $errors[] = 'The uploaded file exceeds the 2MB filesize limit.';
        redirect('/post.php');
    }
    $user = $_SESSION['user'];
    $extension = explode('.', $post['name']);
    $date = date('Y-m-d H:i:s');
    if (isset($_POST['caption'])) {
        $caption = trim(filter_var($_POST['caption'],FILTER_SANITIZE_STRING));
    } else {
        $caption = "";
    }

    $queryFetchPosts = 'SELECT * FROM posts WHERE user_id = :user_id';
    $statement = $pdo->prepare($queryFetchPosts);
    $statement->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    if(empty($posts)) {
        $postPath = $user['username'] . '-1.' . $extension[1]; // Define the path of the post for the first post by this user
        move_uploaded_file($post['tmp_name'], __DIR__.'/../database/posts/'.$postPath);

        $queryInsertPost = 'INSERT INTO posts (user_id, post_text, post_image, datetime) VALUES (:user_id, :post_text, :post_image, :datetime)';
        $statement = $pdo->prepare($queryInsertPost);
        $statement->execute([
            ':user_id' => $user['id'],
            ':post_text' => $caption,
            ':post_image' => $postPath,
            ':datetime' => $date
        ]);
    } else {
        for ($i = count($posts); $i >= count($posts); $i--) {
            $username = $user['username'];
            $lastPostExtension = explode('.', $posts[$i-1]['post_image']);
            $lastPostNumber = explode("$username-", $lastPostExtension[0]);
            $postNumber = $lastPostNumber[1] + 1;
        };

        $postPath = $user['username'] . '-' . $postNumber . '.' . $extension[1]; // Define the path of the post based on the number of previous posts.
        move_uploaded_file($post['tmp_name'], __DIR__.'/../database/posts/'.$postPath);

        $queryInsertPost = 'INSERT INTO posts (user_id, post_text, post_image, datetime) VALUES (:user_id, :post_text, :post_image, :datetime)';
        $statement = $pdo->prepare($queryInsertPost);
        $statement->execute([
            ':user_id' => $user['id'],
            ':post_text' => $caption,
            ':post_image' => $postPath,
            ':datetime' => $date
        ]);
    }   
}

redirect('/home.php');