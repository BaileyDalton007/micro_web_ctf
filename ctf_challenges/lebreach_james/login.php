<?php
session_start();

// Connect to local SQLite3 database file
$db = new SQLite3('assets/users.db');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // this is SQL injection-prone
    $query = "SELECT password_hash, user_role FROM users WHERE username = '$username'";
    $result = $db->query($query);


    if ($result) {
        $output = $result->fetchArray();
        // get the stored hash and the hash of the input value to compare.
        $account_hash = $output['password_hash'];
        $hash_of_input = hash('sha256', $password);

        $user_role = $output['user_role'];

        if ($account_hash === $hash_of_input) {
            
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_role'] = $user_role;
            
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            margin-left: 45%;
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
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }

        h5 {
            font-size: 14px;
            color: #777;
            margin-top: 10px;
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
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

    <h1>LeLogin</h1>

    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <h5>*Moderators, check your dashboard for information about the recent breach.</h5>

        <input type="submit" value="Login">
    </form>

    <br>
    <a href="register.php" class="header-link">Create an Account</a>

</body>
</html>
