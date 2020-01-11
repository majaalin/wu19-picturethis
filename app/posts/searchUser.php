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

$return = $_POST['return-url'];
redirect("$return");