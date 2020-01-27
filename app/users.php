<?php

declare(strict_types=1);

$users = [];

if (isset($_SESSION['users'])){

    $users = $_SESSION['users'];
    unset($_SESSION['users']);
}
?>