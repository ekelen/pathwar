<?php
include('db.php');
if (isset($_POST['password'])) {
    $password = $_POST['password'];
    $query="SELECT * FROM users2 WHERE username='user' AND password='$password'";
    $result = $mysqli->query($query) or die($mysqli->error);
    if ($result->num_rows > 0) { // login successful
	$data = $result->fetch_row();
	if ($data[1] === 'admin') {
	    echo "Welcome $data[1]!<br />";
	    echo "In case you have forgotten it, your password is: __PASSPHRASE0__";
	}
	else {
	    echo 'Hey! What are you doing here? You are not the admin!<br />';
	}
    }
    else {
	echo '<div>Username or password is incorrect!</div>';
    }
}
else {
?>
<div class="container-fluid">
  <div class="row">
    <div class="span2">
      <div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
	  <li><a href="/">Home</a></li>
	  <li><a href="/?step=1">First injection</a></li>
	  <li><a href="/?step=2">Second injection</a></li>
	</ul>
	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
      </div>
    </div>
    <div class="span10">
      This time, the admin has secured the website by removing their account from the database. Prove them wrong and login with their account ! (<b>Tip</b>: take a look at the mysql documentation for UNION.) <br />
      The request looks like this :<br />
      <div class="code">
	<pre><?php echo htmlentities(file_get_contents('step2.txt'))?></pre>
      </div>
      <form method="POST">
	<input type="text" name="login" value="user" disabled/>
	<input type="password" name="password" />
	<input type='submit'/>
      </form>
    </div>
<?php
}
?>
