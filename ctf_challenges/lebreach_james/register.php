<?php
// Connect to SQLite3 database (or create it if it doesn't exist)
$db = new SQLite3('assets/users.db');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $user_role = $_POST['user_role'] ?? '0';

    if (empty($username) || empty($password)) {
        echo "Username and password cannot be empty.";
    } else {
        // make sure username does not already exist.
        $uname_stmt = $db->prepare("SELECT username FROM users WHERE username = :username");
        $uname_stmt->bindValue(':username', $username, SQLITE3_TEXT);
        try {
            $result = $uname_stmt->execute();

            if ($result && $result->fetchArray()) {
                echo "Error: Username Already Taken!";
            } else {
                // Add account to database.

                $hashedPassword = hash('sha256', $password);

                // Use prepared statement to prevent SQL injection
                $stmt = $db->prepare("INSERT INTO users (username, password_hash, user_role) VALUES (:username, :password_hash, :user_role)");
                $stmt->bindValue(':username', $username, SQLITE3_TEXT);
                $stmt->bindValue(':password_hash', $hashedPassword, SQLITE3_TEXT);
                $stmt->bindValue(':user_role', $user_role, SQLITE3_TEXT);

                try {
                    $stmt->execute();
                    echo "Registration successful!";

                    header("Location: login.php");
                    exit;

                } catch (Exception $e) {
                    echo "Error: " . htmlspecialchars($e->getMessage());
                }
            }


        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }

    }
}
?>

<!-- Registration Form -->
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
    <h2>Register</h2>
    <form method="POST" action="register.php">
        <label>Username: <input type="text" name="username" required></label><br><br>
        <label>Password: <input type="password" name="password" required></label><br><br>
        <input type="hidden" name="user_role" value="0">
        <button type="submit">Register</button>
    </form>
</body>
</html>
