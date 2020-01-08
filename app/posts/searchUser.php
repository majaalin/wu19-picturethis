<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we set a session variable for a profile being viewed.

if(isset($_POST['profileID'])) {
    if($_POST['profileID']===$_SESSION['user']["id"]) {
        redirect("/home.php");
    } else {
    $_SESSION['profileID'] = $_POST['profileID'];
    }
}

redirect("/search.php");