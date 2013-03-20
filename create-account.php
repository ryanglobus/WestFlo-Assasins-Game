<?php
require_once '_util.php';
require_once 'db/_db.php';

$error_messages = array();

function handlePost() {
  global $error_messages, $DORMS;
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];
  $dorm = $_POST['dorm'];

  # TODO: finish; check not valid, then add to DB

  // check all required values present
  if (!$email) array_push($error_messages, "You must provide your email address.");
  if (!$password) array_push($error_messages, "You must provide a password.");
  // 0 is a valid dorm value
  if ($dorm != 0 && !$dorm) array_push($error_messages, "You must provide your dorm.");
  if (count($error_messages) > 0) return;

  // check validity of values
  $existing_account = query("select email from User where email = ?", array($email));
  if (count($existing_account) > 0) {
    array_push($error_messages,
      "An account with that email address already exists. Please use a different email address.");
  }
  if ($password != $confirmPassword) {
    array_push($error_messages, "Your password confirmation does not match. Please type in your password exactly the same.");
  }
  if ($dorm < 0 || $dorm >= count($DORMS)) {
    array_push($error_messages, "Please choose a valid dorm value.");
  }

  if (count($error_messages) > 0) return;

  // create the account and log in
  $salt = bin2hex(openssl_random_pseudo_bytes(16));
  $password_digest = crypt($password, $salt);
  query("insert into User (email, password_digest, salt, dorm, alive, is_terminator) values (?, ?, ?, ?, ?, ?)",
    array($email, $password_digest, $salt, $dorm, true, false));
  $results = query("select id from User where email = ?", array($email));
  login($results[0]['id']);
  redirect_to('index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') handlePost();

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Create Account</title>
  </head>
  <body>
    <h1>Assasins - WestFlo</h1>
    <h3>Create an Account</h3>

    <?php
    foreach ($error_messages as $error_message) {
      print '<p class="error">' . $error_message . '</p>';
    }
    ?>

    <form method="post">
      <p>
        <label for="email">Email:</label>
        <input type="email" name="email" />
      </p>
      <p>
        <label for="password">Password:</label>
        <input type="password" name="password" />
      </p>
      <p>
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" name="confirm-password" />
      </p>
      <p>
        <label for="dorm">Dorm:</label>
        <select name="dorm">
          <?php for ($i = 0; $i < count($DORMS); $i++) { ?>
            <option value="<?= $i ?>"><?= $DORMS[$i] ?></option>
          <?php } ?>
        </select>
      </p>
      <p><input type="submit" value="Create Account" /></p>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>

  </body>
</html>