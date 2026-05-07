<?php
include 'db.php';

$total = $db->querySingle("SELECT COUNT(*) FROM logs");
$alerts = $db->querySingle("SELECT COUNT(*) FROM alerts");

$result = $db->query("SELECT ip, COUNT(*) as count FROM logs GROUP BY ip ORDER BY count DESC LIMIT 5");

$top_ips = [];

while ($row = $result->fetchArray()) {
    $top_ips[] = $row;
}

echo json_encode([
    "total_logs" => $total,
    "total_alerts" => $alerts,
    "top_ips" => $top_ips
]);
?>
