<?php
session_start();

if(!isset($_SESSION['user_id']))
{
	$_SESSION['start1']=true;
	header("Location: loginmain.php");
    $message = 'You must be logged in to access this page';
}
else
{
    try
    {
        /*** connect to database ***/
        /*** mysql hostname ***/
        $mysql_hostname = 'localhost';

        /*** mysql username ***/
        $mysql_username = 'root';

        /*** mysql password ***/
        $mysql_password = '';

        /*** database name ***/
        $mysql_dbname = 'student_info';


        /*** select the users name from the database ***/
        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
        /*** $message = a message saying we have connected ***/

        /*** set the error mode to excptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*** prepare the insert ***/
        $stmt = $dbh->prepare("SELECT sso_username FROM sso_users 
        WHERE sso_user_id = :sso_user_id");

        /*** bind the parameters ***/
        $stmt->bindParam(':sso_user_id', $_SESSION['user_id'], PDO::PARAM_INT);

        /*** execute the prepared statement ***/
        $stmt->execute();

        /*** check for a result ***/
        $sso_username = $stmt->fetchColumn();

        /*** if we have no something is wrong ***/
        if($sso_username == false)
        {
            $message = 'Access Error';
			echo $message;
        }
        else
        {
            $message = $sso_username;
        }
    }
    catch (Exception $e)
    {
        /*** if we are here, something is wrong in the database ***/
        $message = 'We are unable to process your request. Please try again later"';
		echo $message;
    }
}

?>

<html>
<head>
<title>App 1 - Books </title>
<link rel="stylesheet" href="app1.css">
</head>
<body>
<h2>Howdy, <?php echo $sso_username; ?>!!</h2>
<p> 
<b>Books are the best things ever!!</b> </p>
<br>
Only books can transport you to a magical world!!
<div id="mov">
<table><tr>
<th> <form action="logout.php">
<input type="submit" value="Logout">
</form></th>
<th><form action="members1.php">
<input type="submit" value="App2 - Movie"></form></th></tr></table>
</div></body>
</html>