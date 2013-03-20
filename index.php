<?php

require_once '_util.php';

$currentUser = currentUser();

if (!$currentUser) {
  redirect_to('login.php');
}



?>

<h1>Welcome, <?= $currentUser['email'] ?></h1>