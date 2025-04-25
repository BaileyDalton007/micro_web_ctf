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

echo "<h1>Forum Posts</h1>";
echo "<div class='header'>";
echo "<a href='write_post.php' class='create-post-link'>Create a Post</a>";
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
    body {
        font-family: Arial, sans-serif;
    }
    .header {
        text-align: center;
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
    .create-post-link:hover {
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
