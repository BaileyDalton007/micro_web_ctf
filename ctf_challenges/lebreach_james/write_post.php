<?php
// Create a connection to the SQLite3 database
$db = new SQLite3('assets/posts.db');
session_start();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and collect form data
    $title = htmlspecialchars($_POST['title']);
    $author = 'guest';
    if (isset($_SESSION['loggedin']) and $_SESSION['loggedin'] == true) {
        $author = $_SESSION['username'];
    }

    $post_content = htmlspecialchars($_POST['post_content']);
    
    // Prepare and execute the insert query
    $query = "INSERT INTO posts (post_title, author, post_content) VALUES ('$title', '$author', '$post_content')";
    if ($db->exec($query)) {
        echo "<p>Post successfully created!</p>";
        // Redirect to the main forum page
        header("Location: posts.php");
        exit;
    } else {
        echo "<p>Error creating post: (SQLite3) " . $db->lastErrorMsg() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Post</title>
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

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 32px;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 18px;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
        }

        .form-group textarea {
            resize: vertical;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #005bb5;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            font-size: 18px;
            color: #0066cc;
            text-decoration: none;
        }

        .back-link:hover {
            color: #005bb5;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Create a New Post</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="title">Post Title</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="post_content">Post Content</label>
            <textarea id="post_content" name="post_content" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit">Create Post</button>
        </div>
    </form>
    <a href="posts.php" class="back-link">Back to Forum</a>
</div>

</body>
</html>
