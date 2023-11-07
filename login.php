<?php
session_start();

// Connect to the database
$mysqli = new mysqli('localhost', 'username', 'password', 'database_name');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Gather the posted data
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Query the database
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows == 1) {
        // Check if the password is correct
        if (password_verify($password, $hashed_password)) {
            // User is logged in successfully, create a session and redirect them to welcome.php
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            header('Location: /welcome.php');
            exit; // Correctly placed exit() after the redirection
        } else {
            // Invalid password
            echo 'Invalid username or password.';
        }
    } else {
        // Invalid username
        echo 'Invalid username or password.';
    }

    // Close the statement and connection
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>