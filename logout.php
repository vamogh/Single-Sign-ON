
<?php
session_start();
session_unset();
// Destroy the session.
session_destroy();
?>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Logged Out</title>
</head>

<body>
<br>
<h1>Logged out successfully!!</h1>

<p><b><i> Go again? </b></i></p>
<frameset><table><tr><th>
<form action="members.php">
<input type="submit" value="App 1 - Books"></form></th>
<th><form action="members1.php">
<input type="submit" value="App 2 - Movies"></form></th></tr>
</table></frameset>
</body>
</html>