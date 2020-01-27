<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file a session variable is set for a profile being viewed.
// The file redirects back to the page it was called from (search.php or feed.php).

if(isset($_POST['profileID'])) {
    if($_POST['profileID']===$_SESSION['user']["id"]) {
        redirect("/home.php");
    } else {
    $_SESSION['profileID'] = $_POST['profileID'];
    };
};

if (isset($_GET['search'])){
    $search = $_GET['search'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR username LIKE '%$search%'");

    $statement->execute();

    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) > 0){
        $_SESSION['users'] = $users;
        redirect('/../../search.php');
        exit;
    } 
    else {
    $errors[] = "Can't find user, try again";
    $_SESSION['errors'] = $errors;
    redirect('/../../search.php');
    exit;
    }
}

redirect('/../../search.php');


// $return = $_POST['return-url'];
// redirect("$return");