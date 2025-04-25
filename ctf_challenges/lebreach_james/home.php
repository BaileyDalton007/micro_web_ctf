<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 30px;
            text-align: center;
        }

        h1 {
            font-size: 36px;
            color: #2d3748;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 24px;
            color: #2d3748;
            margin-bottom: 30px;
        }

        .header {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .header a {
            font-size: 18px;
            color: #fff;
            background-color: #0066cc;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .header a:hover {
            background-color: #004a99;
        }

        .moderator-link {
            background-color: #a32d2d;
        }

        .moderator-link:hover {
            background-color: #e74c3c;
        }

        .logout-link {
            display: inline-block;
            margin-top: 20px;
            font-size: 18px;
            color: #3498db;
            text-decoration: none;
        }

        .logout-link:hover {
            text-decoration: underline;
        }

        .flag {
            font-size: 18px;
            color: #27ae60;
            margin-top: 30px;
        }

        .post {
            background-color: #fff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .pagination {
            text-align: center;
            margin-top: 30px;
        }

        .pagination a {
            padding: 10px 15px;
            margin: 0 5px;
            text-decoration: none;
            background-color: #f1f1f1;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        .pagination strong {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <?php 
        if ($_SESSION['user_role'] == "1") {
            echo "<h1>Welcome (MODERATOR) " . htmlspecialchars($_SESSION['username']) . "</h1>";
        } else {
            echo "<h1>Welcome " . htmlspecialchars($_SESSION['username']) . "</h1>";
        }

        if ($_SESSION['username'] == "Lebron") {
            echo "<h3 class='flag'>Flag of the King: " . file_get_contents('flag.txt') . "</h3>";
        }
    ?>

    <div class="header">
        <a href="write_post.php" class="create-post-link">Create a Post</a>
        <a href="posts.php" class="view-post-link">View Posts</a>
        <?php
        if ($_SESSION['user_role'] == "1") {
            echo "<a href='moderator_dashboard.php' class='moderator-link'>View Moderator Dashboard</a>";
        }
        ?>
    </div>

    <a href="login.php" class="logout-link">Logout</a>

</body>
</html>
