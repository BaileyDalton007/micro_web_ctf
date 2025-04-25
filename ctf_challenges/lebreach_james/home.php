<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

echo "<h1>Welcome " . htmlspecialchars($_SESSION['username']) . "</h1>";
echo "<div class='header'>";
echo "<a href='write_post.php' class='create-post-link'>Create a Post</a>";
echo "<a href='posts.php' class='view-post-link'>View Posts</a>";
echo "</div>";
echo "<a href='login.php'>Logout</a>";
?>

<style>
    body {
        font-family: Arial, sans-serif;
    }
    .header {
        text-align: left;
        margin-bottom: 20px;
    }
    .create-post-link {
        font-size: 20px;
        color: #0066cc;
        text-decoration: none;
        border: 1px solid #0066cc;
        padding: 10px 20px;
        background-color: #f1f1f1;
        border-radius: 5px;
    }
    .view-post-link {
        font-size: 20px;
        color: #0066cc;
        text-decoration: none;
        border: 1px solid #0066cc;
        padding: 10px 20px;
        background-color: #f1f1f1;
        border-radius: 5px;
    }
    .create-post-link:hover {
        background-color: #0066cc;
        color: white;
    }
    .view-post-link:hover {
        background-color: #0066cc;
        color: white;
    }
    .post {
        border: 1px solid #ddd;
        padding: 10px;
        margin: 10px 0;
    }
    .pagination {
        text-align: center;
        margin-top: 20px;
    }
    .pagination a {
        padding: 5px 10px;
        margin: 0 5px;
        text-decoration: none;
        background-color: #f1f1f1;
        border: 1px solid #ccc;
    }
    .pagination a:hover {
        background-color: #ddd;
    }
    .pagination strong {
        font-weight: bold;
    }
</style>