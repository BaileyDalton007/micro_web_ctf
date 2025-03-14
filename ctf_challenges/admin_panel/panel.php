<?php
$flag = file_get_contents('flag.txt');

if (isset($_GET['username'])) {
    // Get the username parameter from the URL
    $username = $_GET['username'];
} else {
    $username = "guest";
}
?>

<!DOCTYPE html>
<h1>Welcome to my super secure Admin Panel!</h1>
<p>Only the admin user can access my flag</p>

<p>Hello, <strong><?php echo $username; ?></strong>!</p>

<?php if ($username == "admin"): ?>
    <h2>Here is your flag, safe and sound: <?php echo $flag; ?></h2>
<?php endif; ?>

<form method="GET" action="" onsubmit="return validateUsername()">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <input type="submit" value="Submit">
</form>

<script>
    // JavaScript to prevent form submission if the username is 'admin'
    function validateUsername() {
        var username = document.getElementById('username').value.trim();
        if (username === 'admin') {
            alert('You are not authorized to log in as admin!');
            return false;
        }
        return true;
    }
</script>

</html>
