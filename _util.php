<?php

require_once 'db/_db.php';

$DORMS = ['Gavilan', 'Loro', 'Mirlo', 'Paloma'];

session_start();

function login($userId) {
  $_SESSION['userId'] = $userId;
}

function logout() {
  $_SESSION['userId'] = null;
}

function currentUserId() {
  if (isset($_SESSION['userId'])) return $_SESSION['userId'];
  else return null;
}

function currentUser() {
  $users = query('select * from User where id = ?', array(currentUserId()));
  if (count($users) == 0) return null;
  else return $users[0];
}

function redirect_to($location) {
  header('Location: '.$location);
  exit();
}

?>