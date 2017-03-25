<?php
session_start();
if(isset($_SESSION['wrong'])){
	unset($_SESSION['wrong']);
	echo "Enter username/password correctly.";
}
elseif(isset($_SESSION['user_id'])){
	echo "Logged in";
	header("Location: members.php");
}
?>

<html>
<head>
<title>Login for Apps</title>
</head>

<body>
<h2>Login Here</h2>
<form action="identity_provider.php" method="post">
<fieldset>
<p>
<label for="sso_username"><b>Username</b> </label>
<input type="text" id="sso_username" name="sso_username" value="" maxlength="20" />
</p>
<p>
<label for="sso_password"><b>Password</b></label>
<input type="password" id="sso_password" name="sso_password" value="" maxlength="20" />
</p>
<p>
<input type="submit" value="→ Login" />
</p>
</fieldset>
</form>
<form action="adduser.php">
<input type="submit" value="Register">
</form>
</body>
</html>
