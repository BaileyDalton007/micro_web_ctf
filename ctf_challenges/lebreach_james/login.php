<?php
session_start();

// Connect to database (adjust credentials as needed)
$mysqli = new mysqli("localhost", "root", "", "testdb");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // 🚨 VULNERABLE: Directly interpolating user input into the SQL query
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: protected.php");
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insecure Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
