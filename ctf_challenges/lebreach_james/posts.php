<?php
// Create a connection to the SQLite3 database
$db = new SQLite3('assets/posts.db');

// Define the number of posts per page
$posts_per_page = 5;

// Get the current page number from the URL, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record for the query
$start_from = ($page - 1) * $posts_per_page;

// SQL query to fetch posts with pagination
$query = "SELECT * FROM posts LIMIT $start_from, $posts_per_page";
$result = $db->query($query);

// Check if there are any posts
$posts_found = false;

echo "<div class='header'>";
echo "<h1>LeForum Posts</h1><br>";
echo "<a href='write_post.php' class='create-post-link'>Create a Post</a>";
echo "<a href='home.php' class='home-link'>Home</a>";
echo "</div>";

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $posts_found = true;
    echo "<div class='post'>";
    echo "<h2>" . htmlspecialchars($row['post_title']) . "</h2>";
    echo "<p>By: " . htmlspecialchars($row['author']) . "</p>";
    echo "<p>" . nl2br(htmlspecialchars($row['post_content'])) . "</p>";
    
    if ($row['image_path'] !== null) {
        echo "<img src='assets/" . $row['image_path'] ."'>";
    }
    echo "<hr>";
    echo "</div>";
}

if (!$posts_found) {
    echo "<p>No posts found.</p>";
}

// Count the total number of posts for pagination
$sql_total = "SELECT COUNT(*) FROM posts";
$result_total = $db->query($sql_total);
$row_total = $result_total->fetchArray();
$total_posts = $row_total[0];

// Calculate the total number of pages
$total_pages = ceil($total_posts / $posts_per_page);

// Pagination links
echo "<div class='pagination'>";
if ($page > 1) {
    echo "<a href='?page=" . ($page - 1) . "'>&laquo; Previous</a> ";
}
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "<strong>$i</strong> ";
    } else {
        echo "<a href='?page=$i'>$i</a> ";
    }
}
if ($page < $total_pages) {
    echo "<a href='?page=" . ($page + 1) . "'>Next &raquo;</a>";
}
echo "</div>";
?>

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
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .create-post-link,
    .home-link {
        font-size: 18px;
        color: #0066cc;
        text-decoration: none;
        border: 1px solid #0066cc;
        padding: 10px 20px;
        background-color: #f1f1f1;
        border-radius: 5px;
        margin: 0 10px;
    }

    .create-post-link:hover,
    .home-link:hover {
        background-color: #0066cc;
        color: white;
    }

    .post {
        background-color: white;
        padding: 20px;
        border: 1px solid #ddd;
        margin: 20px 0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .post h2 {
        font-size: 28px;
        margin-bottom: 10px;
        color: #333;
    }

    .post p {
        font-size: 18px;
        color: #666;
        margin-bottom: 10px;
    }

    .post img {
        max-width: 100%;
        margin-top: 20px;
        border-radius: 8px;
    }

    .pagination {
        text-align: center;
        margin-top: 30px;
    }

    .pagination a,
    .pagination strong {
        padding: 8px 16px;
        margin: 0 5px;
        text-decoration: none;
        background-color: #f1f1f1;
        border: 1px solid #ccc;
        border-radius: 5px;
        color: #0066cc;
    }

    .pagination a:hover {
        background-color: #0066cc;
        color: white;
    }

    .pagination strong {
        font-weight: bold;
        color: #333;
    }
</style>
