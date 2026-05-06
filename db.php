<?php
$db = new SQLite3('logs.db');

$db->exec("CREATE TABLE IF NOT EXISTS logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip TEXT,
    user_agent TEXT,
    request_method TEXT,
    path TEXT,
    timestamp INTEGER
)");

$db->exec("CREATE TABLE IF NOT EXISTS alerts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip TEXT,
    reason TEXT,
    timestamp INTEGER
)");
?>
