<?php
require_once '_util.php';
require_once 'db/_db.php';

$error = false;

function handlePost() {
  global $error;
  $email = $_POST['email'];
  $password = $_POST['password'];
  $users = query("select id, password_digest, salt from User where email = ?",
    array($email));
  if (count($users) == 0) {
    $error = true;
    return;
  }
  $user = $users[0];

  if (crypt($password, $user['salt']) == $user['password_digest']) {
    login($user['id']);
    redirect_to('index.php');
  } else {
    $error = true;
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') handlePost();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
  </head>
  <body>
    <h1>Assasins - WestFlo</h1>

    <?php if ($error) { ?>
      <p class="error">
        Invalid login credentials.
        Try again or <a href="create-account.php">create an account.</a>
      </p>
    <?php } ?>

    <form method="post">
      <p>
        <label for="email">Email:</label>
        <input type="email" name="email" />
      </p>
      <p>
        <label for="password">Password:</label>
        <input type="password" name="password" />
      </p>
      <p><input type="submit" value="Login" /></p>
    </form>

    <p>Don't have an account? <a href="create-account.php">Create one here.</a></p>

  </body>
</html>