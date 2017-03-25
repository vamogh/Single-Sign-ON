<?php
session_start();

/*** check if the users is already logged in ***/
if(isset( $_SESSION['user_id'] ))
{
	header("Location: members1.php");
    $message = 'User is already logged in';
	
}
/*** checking if both username and password are filled ***/
elseif(!isset( $_POST['sso_username'], $_POST['sso_password']))
{
	$_SESSION['wrong']=true;
	header("Location: loginmain.php");
    $message = 'Please enter a valid username and password';
}
/*** check the username is the correct length ***/
elseif (strlen( $_POST['sso_username']) > 20 || strlen($_POST['sso_username']) < 8)
{
    $_SESSION['wrong']=true;
	header("Location: loginmain.php");
    $message = 'Please enter a valid username and password';
}
/*** check the password is the correct length ***/
elseif (strlen( $_POST['sso_password']) > 20 || strlen($_POST['sso_password']) < 8)
{
	$_SESSION['wrong']=true;
	header("Location: loginmain.php");
    $message = 'Please enter a valid username and password';
}
/*** checking if username is alphanumeric ***/
elseif (ctype_alnum($_POST['sso_username']) != true)
{
    $_SESSION['wrong']=true;
	header("Location: loginmain.php");
    $message = 'Please enter a valid username and password';
}
/*** checking if password is alphanumeric ***/
elseif (ctype_alnum($_POST['sso_password']) != true)
{
     $_SESSION['wrong']=true;
	header("Location: loginmain.php");
    $message = 'Please enter a valid username and password';
}
/*** checking if password satisfies requirements ***/
elseif (!preg_match('/[A-Z]+[a-z]+[0-9]+/', $_POST['sso_password']))
{
	$_SESSION['wrong']=true;
	header("Location: loginmain.php");
    $message = 'Please enter a valid username and password';
}
else
{
    /*** data is valid and insert it into database ***/
    $sso_username = filter_var($_POST['sso_username'], FILTER_SANITIZE_STRING);
    $sso_password = filter_var($_POST['sso_password'], FILTER_SANITIZE_STRING);

    /*** encrypt the password ***/
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

        /*** error mode to excptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*** prepare the select statement ***/
        $stmt = $dbh->prepare("SELECT sso_user_id, sso_username, sso_password FROM sso_users 
                    WHERE sso_username = :sso_username AND sso_password = :sso_password");

        /*** bind the parameters ***/
        $stmt->bindParam(':sso_username', $sso_username, PDO::PARAM_STR);
        $stmt->bindParam(':sso_password', $sso_password, PDO::PARAM_STR, 40);

        /*** execute the prepared statement ***/
        $stmt->execute();

        /*** check for a result ***/
        $user_id = $stmt->fetchColumn();

        /*** if no result then redirect to loginmain ***/
        if($user_id == false)
        {
                $_SESSION['wrong']=true;
				header("Location: loginmain.php");				
				$message = 'Login Failed';
        }
        /*** result, all is well ***/
        else
        {
                /*** setting the session user_id variable ***/
                $_SESSION['user_id'] = $user_id;
				if(isset($_SESSION['start1'])&&$_SESSION['start1']){
					unset($_SESSION['start1']);
					header("Location: members.php");
				}
				elseif(isset($_SESSION['start2'])&&$_SESSION['start2']){
					unset($_SESSION['start2']);
					header("Location: members1.php");
				}
				else
					header("Location: members.php");
				/*** tell the user logged in ***/
                $message = 'You are now logged in';
				
		}
		


    }
    catch(Exception $e)
    {
        /*** something has gone wrong with the database ***/
        $message = 'We are unable to process your request. Please try again later"';
    }
}
?>

<html>
<head>
<title>SSo Login</title>
</head>
<body>
<?php echo $message; ?>
</body>
</html>