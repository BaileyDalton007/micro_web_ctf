<?php
// Create (or open) the database file
if (!file_exists('assets/')) {
    mkdir('assets/');
}

$db = new SQLite3('assets/users.db');

// Create users table
$db->exec("CREATE TABLE IF NOT EXISTS users (
    username TEXT PRIMARY KEY,
    password_hash TEXT NOT NULL,
    user_role TEXT NULL
)");

// Create usernames and their passwords
$users = [
    "KingJamesFan42" => "SPURS17",
    "LeBron4Life23" => "h3AT2",
    "BronnyFan" => "KN1ckS00",
    "HoopsMaster21" => "suns97",
    "BasketballGuru" => "HAWKS53",
    "YoungHoopsFan" => "NUGG3TS7",
    "CavsForever" => "W1zards9",
    "BigFan22" => "grizz1ies87",
    "NBAHistorian" => "JAZZ8",
    "Lebron" => "THUND3R05"
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

echo "Database created and users inserted into users.db\n";

$file = fopen("breach.txt", "w");

foreach ($users as $username => $password) {
    if ($username !==  'Lebron') {
        fwrite($file, "$username, $password\n");
    }
}

fclose($file);
echo "User dictionary written to breach.txt\n";

