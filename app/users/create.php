<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called when an account is created.

$errors = [];

// Check that all variables exist in the POST request and sanitize and encrypt passwprd.
if (isset($_POST['firstname'],$_POST['lastname'],$_POST['username'],$_POST['bio'],$_POST['email'], $_POST['password'])) {
    $firstname = trim(filter_var($_POST['firstname'], FILTER_SANITIZE_STRING));
    $lastname = trim(filter_var($_POST['lastname'], FILTER_SANITIZE_STRING));
    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $htmlPassword = trim(htmlentities($_POST['password']));
    $password = password_hash($htmlPassword, PASSWORD_DEFAULT);
    if(isset($_POST['bio'])) {
        $bio = trim(filter_var($_POST['bio'], FILTER_SANITIZE_STRING));
    } else {
        $bio = "";
    };
    
    // Check username and email doesn't already exist.
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
        redirect('/create.php');
    } elseif ($usernameExists) {
        $errors[] = 'The username you\'ve selected is already taken. What else could you imagine calling yourself?';
        $_SESSION['errors'] = $errors;
        redirect('/create.php');
    } elseif ($emailExists) {
        $errors[] = 'The email you\'ve entered is already taken. Do you perhaps already have an account?';
        $_SESSION['errors'] = $errors;
        redirect('/create.php');
    } elseif (contains('-', $username) || contains('.', $username)) {
        $errors[] = 'The characters "-" or "." are not suited for a username.';
        $_SESSION['errors'] = $errors;
        redirect('/create.php');
    };

    // Create account and insert new user's details into the database.
    $queryCreate = 'INSERT INTO users (firstname, lastname, username, bio, email, password) VALUES (:firstname, :lastname, :username, :bio, :email, :password)';
    $statement = $pdo->prepare($queryCreate);
    if (!$statement) {
        $errors[] = 'An error occured creating your account. Please try again.';
        $_SESSION['errors'] = $errors;
        redirect('/create.php');
    };
    $statement->execute([
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':username' => $username,
        ':bio' => $bio,
        ':email' => $email,
        ':password' => $password
    ]);

    // Log the new user in.
    $queryLogin = 'SELECT * FROM users WHERE email = :email';
    $statement = $pdo->prepare($queryLogin);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        $errors[] = 'An error occured creating your account. Please try again.';
        $_SESSION['errors'] = $errors;
        redirect('/create.php');
    };
    // Verify the password doesn't contain any special characters (verifies against htmlentities function above).
    if (password_verify($_POST['password'], $user['password'])) {
        // If the password is valid, remove the password from the session.
        unset($user['password']);
        $_SESSION['user'] = $user;
    } else {
        $errors[] = 'Please choose a password without spaces or special characters.';
        $_SESSION['errors'] = $errors;
        redirect('/create.php');
    };
};

redirect('/home.php');