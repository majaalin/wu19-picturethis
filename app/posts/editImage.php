<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called whenever a post image is replaced.
header('Content-Type: application/json');


if(isset($_FILES['editedIMG'])) {
    $editedIMG = $_FILES['editedIMG'];
    $postID = intval(filter_var($_POST['post-id'], FILTER_SANITIZE_NUMBER_INT));

    $newExtension = explode('.', $editedIMG['name']);
    if (contains('-', $newExtension[0]) || contains('.', $newExtension[0])) {
        echo json_encode(['error' => 'Your replacement image must not contain characters "-" or "." in the title (other than .jpg, .jpeg or .png).'], 400);
        exit;
    };

    $queryFetchPosts = 'SELECT * FROM posts WHERE user_id = :user_id AND post_id = :post_id';
    $statement = $pdo->prepare($queryFetchPosts);
    $statement->execute([
        ':user_id' => $_SESSION['user']['id'],
        ':post_id' => $postID
    ]);
    $oldPost = $statement->fetch(PDO::FETCH_ASSOC);
    $oldPostArray = explode('.', $oldPost['post_image']);
    $newExtension = explode('.', $editedIMG['name']);
    $postPath = $oldPostArray[0] . '.' . $newExtension[1];
    unlink(__DIR__.'/../database/posts/'.$oldPost['post_image']);
    move_uploaded_file($editedIMG['tmp_name'], __DIR__.'/../database/posts/'.$postPath);

    $queryUpdatePostImage = 'UPDATE posts SET post_image = :post_image WHERE post_id = :post_id';
    $statement = $pdo->prepare($queryUpdatePostImage);
    $statement->execute([
        ':post_id' => $postID,
        ':post_image' => $postPath
    ]);

    $newPost = [
        'postIMG' => $postPath,
    ];
    $newPost = json_encode($newPost);
    echo $newPost;
};