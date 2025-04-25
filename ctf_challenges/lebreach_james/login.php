<?php
session_start();

// Connect to local SQLite3 database file
$db = new SQLite3('users.db');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // this is SQL injection-prone
    $query = "SELECT password_hash FROM users WHERE username = '$username'";
    $result = $db->query($query);


    if ($result) {
        // get the stored hash and the hash of the input value to compare.
        $account_hash = $result->fetchArray()['password_hash'];
        $hash_of_input = hash('sha256', $password);

        if ($account_hash === $hash_of_input) {
            
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: home.php");
            exit;

        } else {
            $error = "Invalid credentials for account $username";
        }

    } else {
        $error = "Account $username does not exist";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <h5>due to the recent password breach, you are no longer automatically assigned a password so you may input your own.</h5>

        <input type="submit" value="Login">
    </form>
</body>
</html>
