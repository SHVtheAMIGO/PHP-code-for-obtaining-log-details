<?php

$one_minute_ago = time() - 60;

$stmt = $db->prepare("SELECT COUNT(*) as count FROM logs WHERE ip = ? AND timestamp > ?");
$stmt->bindValue(1, $ip);
$stmt->bindValue(2, $one_minute_ago);
$result = $stmt->execute()->fetchArray();

if ($result['count'] > 20) {
    $stmt = $db->prepare("INSERT INTO alerts (ip, reason, timestamp) VALUES (?, ?, ?)");
    $stmt->bindValue(1, $ip);
    $stmt->bindValue(2, "Too many requests");
    $stmt->bindValue(3, time());
    $stmt->execute();
}

if (strpos($path, "admin") !== false) {
    $stmt = $db->prepare("INSERT INTO alerts (ip, reason, timestamp) VALUES (?, ?, ?)");
    $stmt->bindValue(1, $ip);
    $stmt->bindValue(2, "Admin path access");
    $stmt->bindValue(3, time());
    $stmt->execute();
}

if (stripos($user_agent, "curl") !== false || stripos($user_agent, "bot") !== false) {
    $stmt = $db->prepare("INSERT INTO alerts (ip, reason, timestamp) VALUES (?, ?, ?)");
    $stmt->bindValue(1, $ip);
    $stmt->bindValue(2, "Suspicious user agent");
    $stmt->bindValue(3, time());
    $stmt->execute();
}

?>
