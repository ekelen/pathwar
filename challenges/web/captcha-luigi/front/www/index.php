<?php
  session_start();
  if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
  }

  if (isset($_POST['password']) && isset($_SESSION['password'])) {
    if ($_POST['password'] == $_SESSION['password']) {
      $_SESSION['score']++;
      unset($_SESSION['password']);
      echo "<p>You win !</p>";
    } else {
      echo "<p>You lose !</p>";
    }
  }

  echo '<p>Score: ', $_SESSION['score'], '/100';

  if ($_SESSION['score'] >= 100) {
    echo "<p>The passphrase is: {passphrase}</p>";
  }
?>
<div>
  <img src="./captcha.php" />
</div>
<div>
  <form method="POST">
    <input name="password" type="text" />
    <input type="submit" />
  </form>
</div>
