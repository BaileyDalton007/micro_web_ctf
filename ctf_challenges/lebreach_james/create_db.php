<?php
// Create (or open) the database file
$db = new SQLite3('users.db');

// Create users table
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    password TEXT NOT NULL
)");

// Insert sample users
$db->exec("INSERT INTO users (username, password) VALUES 
    ('admin', 'admin123'),
    ('alice', 'password1'),
    ('bob', 'qwerty'),
    ('charlie', '123456')
");

echo "Database created and users inserted into users.db\n";
