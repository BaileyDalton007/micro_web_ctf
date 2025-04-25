<?php
// Create (or open) the database file
$db = new SQLite3('lebron.db');

// Create users table
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
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

    $stmt = $db->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password_hash', $pw_hash, SQLITE3_TEXT);
    $stmt->execute();
}
echo "Database created and users inserted into lebron.db\n";


$file = fopen("breach.txt", "w");

foreach ($users as $username => $password) {
    fwrite($file, "$username, $password\n");
}

fclose($file);
echo "User dictionary written to users.txt\n";

