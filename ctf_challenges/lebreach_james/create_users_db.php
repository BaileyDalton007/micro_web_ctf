<?php
// Create (or open) the database file
$db = new SQLite3('users.db');

// Create users table
$db->exec("CREATE TABLE IF NOT EXISTS users (
    username TEXT PRIMARY KEY,
    password_hash TEXT NOT NULL,
    user_role TEXT NULL
)");

// Create usernames and their passwords
$users = [
    "alice" => "SPURS17",
    "bob" => "h3AT2",
    "john" => "THUND3R05"
];

// Hash each user's password and add it to the db.
foreach ($users as $username => $password) {
    $pw_hash = hash('sha256', $password);
    $user_role = 0;

    $stmt = $db->prepare("INSERT INTO users (username, password_hash, user_role) VALUES (:username, :password_hash, :user_role)");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password_hash', $pw_hash, SQLITE3_TEXT);
    $stmt->bindValue(':user_role', $user_role, SQLITE3_TEXT);
    $stmt->execute();
}

chmod('users.db, 0666');
echo "Database created and users inserted into users.db\n";


$file = fopen("breach.txt", "w");

foreach ($users as $username => $password) {
    fwrite($file, "$username, $password\n");
}

fclose($file);
echo "User dictionary written to breach.txt\n";

