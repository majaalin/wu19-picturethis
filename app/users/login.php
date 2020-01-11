<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we login users.

$errors = [];

// Check if both email and password exists in the POST request.
if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    // Prepare, bind email parameter and execute the database query.
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    // Fetch the user as an associative array.
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    // If we couldn't find the user in the database, redirect back to the login
    // page with our custom redirect function.
    if (!$user) {
        $errors[] = 'No account exists for the email you\'ve entered. Have you created an account yet?';
        $_SESSION['errors'] = $errors;
        redirect('/login.php');
    }
    // If we found the user in the database, compare the given password from the
    // request with the one in the database using the password_verify function.
    if (password_verify($_POST['password'], $user['password'])) {
        // If the password was valid we know that the user exists and provided
        // the correct password. We can now save the user in our session.
        // Remember to not save the password in the session!
        unset($user['password']);
        $_SESSION['user'] = $user;
        $statement = $pdo->prepare('SELECT * FROM avatars WHERE avatar_id = :avatar_id');
        $statement->bindParam(':avatar_id', $user['id'], PDO::PARAM_INT);
        $statement->execute();
        // Fetch the user and avatar and set them as session variables.
        $avatar = $statement->fetch(PDO::FETCH_ASSOC);
        $_SESSION['avatar'] = $avatar['image'];
    } else {
        $errors[] = 'The password you\'ve entered doesn\'t match the username you entered. Why not have another crack?';
        $_SESSION['errors'] = $errors;
        redirect('/login.php');
    }
}
// We should put this redirect in the end of this file since we always want to
// redirect the user back from this file. 
redirect('/home.php');