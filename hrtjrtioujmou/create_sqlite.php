<?php
$env = parse_ini_file('../.env');
// Open a connection to the SQLite database file
// If the file does not exist, it will be created
$DB_NAME = '../' . $env['SQLITE_DB'];
$db = new SQLite3($DB_NAME);

// Check if the database was created successfully
if ($db) {
    echo "Database created successfully\n";
} else {
    echo "Failed to create database\n";
}

// SQL statement to create a new table
$sql = "CREATE TABLE IF NOT EXISTS userlog (
    ID INTEGER PRIMARY KEY AUTOINCREMENT,
    VPN TEXT NOT NULL,
    IP TEXT NOT NULL,
    PROVIDER TEXT NOT NULL,
    COUNTRY TEXT NOT NULL,
    REGION TEXT NOT NULL,
    CITY TEXT NOT NULL,
    TIME TEXT NOT NULL
)";

// Execute the SQL statement
if ($db->exec($sql)) {
    echo "Table created successfully\n";
} else {
    echo "Failed to create table\n";
}
?>