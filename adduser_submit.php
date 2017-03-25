<?php
session_start();

/*** first check that both the username, password and form token have been sent ***/
if(!isset( $_POST['sso_username'], $_POST['sso_password'], $_POST['form_token']))
{
    $message = 'Please enter a valid username and password';
}
/*** check the form token is valid ***/
elseif( $_POST['form_token'] != $_SESSION['form_token'])
{
    $message = 'Invalid form submission';
}
/*** check the username is the correct length ***/
elseif (strlen( $_POST['sso_username']) > 20 || strlen($_POST['sso_username']) < 8)
{
    $message = 'Incorrect Length for Username';
}
/*** check the password is the correct length ***/
elseif (strlen( $_POST['sso_password']) > 20 || strlen($_POST['sso_password']) < 8)
{
    $message = 'Incorrect Length for Password';
}
/*** check the username has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['sso_username']) != true)
{
    /*** if there is no match ***/
    $message = "Username must be alpha numeric";
}
/*** check the password has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['sso_password']) != true)
{
        /*** if there is no match ***/
        $message = "Password must be alpha numeric";
}
/*** check if password satisfies condition ***/
elseif (!preg_match('/[A-Z]+[a-z]+[0-9]+/', $_POST['sso_password']))
{
    $message = "Password must contain atleast 1 uppercase letter, 1 lowercase letter and 1 numerical digit";
}
/*** check if uname and password are same ***/
elseif (!strcmp($_POST['sso_username'], $_POST['sso_password'])){
	$message = "Username and password can not be the same";
}
/*** check if password and conf_password are same ***/
elseif (strcmp($_POST['sso_password'], $_POST['conf_password'])){
	$message = "Passwords do not match!";
}
else
{
    /*** data is valid and insert it into database ***/
    $sso_username = filter_var($_POST['sso_username'], FILTER_SANITIZE_STRING);
    $sso_password = filter_var($_POST['sso_password'], FILTER_SANITIZE_STRING);

    /*** now encrypt the password ***/
    $sso_password = sha1( $sso_password );
    
    /*** connect to database ***/
    /*** mysql hostname ***/
    $mysql_hostname = 'localhost';

    /*** mysql username ***/
    $mysql_username = 'root';

    /*** mysql password ***/
    $mysql_password = '';

    /*** database name ***/
    $mysql_dbname = 'student_info';

    try
    {
        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
        /*** $message = "connected" ***/

        /*** set the error mode to excptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*** prepare the insert ***/
        $stmt = $dbh->prepare("INSERT INTO sso_users (sso_username, sso_password ) VALUES (:sso_username, :sso_password )");

        /*** bind the parameters ***/
        $stmt->bindParam(':sso_username', $sso_username, PDO::PARAM_STR);
        $stmt->bindParam(':sso_password', $sso_password, PDO::PARAM_STR, 40);

        /*** execute the prepared statement ***/
        $stmt->execute();

        /*** unset the form token session variable ***/
        unset( $_SESSION['form_token'] );

        /*** if all is done ***/
        $message = 'New user added';
    }
    catch(Exception $e)
    {
        /*** check if the username already exists ***/
        if( $e->getCode() == 23000)
        {
			$flag = 1;
            $message = 'Username already exists';
        }
        else
        {
            /*** something has gone wrong with the database ***/
            $message = 'We are unable to process your request. Please try again later"';
        }
    }
}
?>

<html>
<head>
<title>SSO Register</title>
</head>
<body>
<p><?php 
echo $message;
 ?>
 <br><br>
 <table><tr>
<th> <form action="adduser.php">
<input type="submit" value="Register">
</form></th>
<th><form action="loginmain.php">
<input type="submit" value="Login"></form></th></tr></table>
</body>
</html>