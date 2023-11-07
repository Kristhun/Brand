<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully!";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

$sql = "SELECT id, username FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<body>

<h2>Admin Panel</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Action</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["username"] . "</td><td><a href='admin_panel.php?delete=" . $row["id"] . "'>Delete</a></td></tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No users found.</td></tr>";
    }
    $conn->close();
    ?>
</table>

<a href="logout.php">Logout</a>

</body>
</html>