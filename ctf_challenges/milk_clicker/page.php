<?php
// init to 0 if cookie does not exist
if (isset($_COOKIE['score'])) {
    $score = $_COOKIE['score'];
} else {
    $score = 0;
}

// Check if the score needs to be updated (when the image is clicked)
if (isset($_GET['increment'])) {
    $score++;
    setcookie('score', $score, time() + (86400), "/"); // Cookie lasts for a day
    header("Location: page.php");
    exit();
}

$flag = file_get_contents('flag.txt');

?>

<!DOCTYPE html>
<head>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .scoreboard {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .clickable-image {
            cursor: pointer;
            width: 300px;
            height: auto;
            transition: transform 0.2s ease;
        }
        .clickable-image:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <h1>Milk Clicker, the Experience</h1>
    <p>I will only give you my flag if you provide enough milk for the ENTIRE WORLD! (8 Billion)</p>
    <p> You know what goes well with a glass of milk? ...nevermind </p>

    <div class="scoreboard">
        <p>Your milk: <?php echo $score; ?></p>
    </div>

    <?php if ($score > 8_000_000_000): ?>
        <div class="flag">
        <p>
            Congratulations, you have solved world hunger!<br>
                
            Here is your flag: <?php echo $flag; ?><br>

            Forget the lactose intolerant, they were goners anyway.<br>
        </p>
        </div>
    <?php else: ?>
        <a href="?increment=true">
            <img src="milk.webp" alt="Clickable milk!" class="clickable-image">
        </a>

        <p>Click the milk to get more milk</p>
    <?php endif; ?>
</body>
</html>
