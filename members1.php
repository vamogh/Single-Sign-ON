<?php
session_start();
if(!isset($_SESSION["user_id"])){
	$_SESSION['start2']=true;
	header("Location: loginmain.php");
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
        /*** $message = "connected" ***/

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

        /*** something is wrong ***/
        if($sso_username == false)
        {
            $message = 'Access Error';
			echo $message;
        }
        else
        {
            $message = 'Welcome '.$sso_username;
        }
    }
    catch (Exception $e)
    {
        /*** if we are here, something is wrong in the database ***/
        $message = 'We are unable to process your request. Please try again later"';
    }
}

?>
<html>
<head> <title> App 2 - Movies </title><h1>Hello, <?php echo $sso_username ?></h1>
<link rel="stylesheet" href="app2.css">
</head>
<body>
<h2> App2 - Movies </h2>
<p> <h3> <b> Like a rat in a rattrap gentlemen!!</b> </h3><br>
Where have you heard this dialogue??<br>

Well it's from <i>The Dark Knight Rises </i>.<br><br>
If you're trying to remember where it occued in the film, go and watch it again. Nolan movies aren't supposed to be forgotten!!</p>
<br>
<div id="mov">
<table><tr>
<th> <form action="logout.php">
<input type="submit" value="Logout">
</form></th>
<th><form action="members.php">
<input type="submit" value="App1 - Books"></form></th></tr></table></div>
</body></html>