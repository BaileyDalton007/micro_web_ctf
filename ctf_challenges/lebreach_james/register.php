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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url('assets/leSilly.jpg');
            background-repeat: repeat; /* This will make the image tile */
            padding: 15%;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 30px;
            color: #333;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 10px;
            display: inline-block; /* Ensures the background only covers the title */
            max-width: 80%; /* Prevents the box from being too wide */
            word-wrap: break-word; /* Handles long words in the title */
            margin-left: 40%;
            margin-right: 50%;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }

        label {
            font-size: 16px;
            color: #555;
            display: block;
            margin-bottom: 5px;
            text-align: left;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .header-link {
            display: block;
            margin: 20px auto; /* centers the box */
            text-align: center;
            font-size: 24px;
            color: #0066cc;
            text-decoration: none;
            background-color: rgba(255, 255, 255, 0.9); /* same as h1 background */
            padding: 15px 25px;
            border-radius: 10px;
            max-width: fit-content;
            font-weight: bold;
        }

        .header-link:hover {
            background-color: #0066cc;
            color: white;
        }
    </style>
</head>
<body>

    <h1>LeRegister</h1>

    <div class="form-container">
        <form method="POST" action="register.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="hidden" name="user_role" value="0">

            <button type="submit">Register</button>
        </form>
    </div>

    <br>
    <a href="login.php" class="header-link">Already Have an Account? Login</a>

</body>
</html>
