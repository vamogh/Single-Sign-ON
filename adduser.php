<?php
session_start();
$form_token = md5( uniqid('auth', true) );
//echo $form_token;
$_SESSION['form_token'] = $form_token;
?>

<html>
<head>
<link rel="stylesheet" href="adduser.css">
<title>SSO Register</title>
</head>

<body>
<div id="addu_h">
<h2>Add user</h2></div>
<form action="adduser_submit.php" method="post">
<fieldset>
<p id="prules">
<ul>
<li> Username must contain a minimum of <b> 8 </b> characters. </li>
<li> Password must contain atleast <i> 1 Uppercase, 1 lowercase and 1 numeric </i>character.</li>
<li> Password must contain a minimum of <b> 8 </b> characters.</li>
</ul></p>
<p>
<label for="sso_username">Username</label><br>
<input type="text" id="sso_username" name="sso_username" value="" maxlength="20" />
</p>
<p>
<label for="sso_password">Password</label><br>
<input type="password" id="sso_password" name="sso_password" value="" maxlength="20" /> <br></p><p><label for="conf_password">
Confirm Password </label> <br>
<input type="password" id="conf_password" name="conf_password" maxlength="20"/>
</p>
<p>
<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
<input type="submit" value="&rarr; Register" />
</p>
</fieldset>
</form>
</body>
</html>