<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Welcome, you are logged in successfully!</h2>
    <a href="logout.php">Logout</a>
</body>
</html>