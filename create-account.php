<?php
require_once '_util.php';
require_once 'db/_db.php';

$error_message = "";

function handlePost() {
  global $error_message;
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];
  $dorm = $_POST['dorm'];

  # TODO: finish; check not blank AND valid, then add to DB

  // check all required values present

  // check validity of values
  $existing_account = query("select email from User where email = ?", array($email));
  if (count($existing_account) > 0) {
    $error_message = "An account with that email address already exists. Please use a different email address.";
  }
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
    if ($error_message) {
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
          <option value="<?php print $GAVILAN; ?>">Gavilan</option>
          <option value="<?php print $LORO; ?>">Loro</option>
          <option value="<?php print $MIRLO; ?>">Mirlo</option>
          <option value="<?php print $PALOMA; ?>">Paloma</option>
        </select>
      </p>
      <p><input type="submit" value="Create Account" /></p>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>

  </body>
</html>