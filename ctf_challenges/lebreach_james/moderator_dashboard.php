<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['user_role'] !== "1") {
    echo "This dashboard is for moderators only.";
} else {
    echo "<h1>ATTENTION MODERATORS</h1>";

    echo "<h3>As you may have heard, our systems were recently breached.</h3>";

    echo "<h3> Below is the file that was sold on the dark net of usernames and ".
     "passwords for our users. Luckily, our glorious king's account was not hacked (another W over Jordan). ".
     "Thank goodness too, or his glorious flags could have been leaked!</h3>";

    echo "<h3>Since the breach we stopped automatically assigning passwords and are now encouraging users ".
    "to change theirs if they haven't. Spread the word to users. Sincerely, LeHeadModerator </h3>";

    echo "<strong>breach.txt</strong> <br>";
    echo nl2br(file_get_contents('breach.txt'));
}

?>