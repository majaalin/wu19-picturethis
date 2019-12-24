<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we create an account and login users.

// Check if both email and password exists in the POST request.
if (isset($_POST['firstname'],$_POST['lastname'],$_POST['username'],$_POST['bio'],$_POST['email'], $_POST['password'])) {
    $firstname = trim(filter_var($_POST['firstname'], FILTER_SANITIZE_STRING));
    $lastname = trim(filter_var($_POST['lastname'], FILTER_SANITIZE_STRING));
    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $htmlPassword = trim(htmlentities($_POST['password']));
    $password = password_hash($htmlPassword, PASSWORD_DEFAULT);
    // password_verify($passphrase, $hash); // true
    if(isset($_POST['bio'])) {
        $bio = trim(filter_var($_POST['bio'], FILTER_SANITIZE_STRING));
    } else {
        $bio = "";
    }
    // Prepare, bind email parameter and execute the database query.

    $queryCreate = 'INSERT INTO users (firstname, lastname, username, bio, email, password) VALUES (:firstname, :lastname, :username, :bio, :email, :password)';
    $statement = $pdo->prepare($queryCreate);
    if (!$statement) {
        redirect('/../../create.php'); // send back to create form somehow
    }
    $statement->execute([
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':username' => $username,
        ':bio' => $bio,
        ':email' => $email,
        ':password' => $password
    ]);

    $queryLogin = 'SELECT * FROM users WHERE email = :email';
    $statement = $pdo->prepare($queryLogin);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    // Fetch the user as an associative array.
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    // If we couldn't find the user in the database, redirect back to the login
    // page with our custom redirect function.
    if (!$user) {
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
    }
}
// We should put this redirect in the end of this file since we always want to
// redirect the user back from this file. We don't know
redirect('/home.php');