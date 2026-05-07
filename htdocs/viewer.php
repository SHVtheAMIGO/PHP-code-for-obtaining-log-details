<?php
session_start();

// --------------------------------------
// CONFIG
// --------------------------------------

// Set your timezone
date_default_timezone_set('Asia/Kolkata');

// CHANGE THIS PASSWORD 🔐
const VIEW_PASSWORD = 'YOUR_PASSWORD';

// Path to the log file (same place log.php writes)
$logDir  = __DIR__ . '/private_logs';
$logFile = $logDir . '/visitors.log';

if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

// --------------------------------------
// AUTH HANDLING
// --------------------------------------

// Logout
if (isset($_GET['logout'])) {
    unset($_SESSION['viewer_auth']);
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// If not authenticated yet, check login
if (!isset($_SESSION['viewer_auth'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if ($password === VIEW_PASSWORD) {
            $_SESSION['viewer_auth'] = true;
            header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
            exit;
        } else {
            $error = "Wrong password, bro 😭";
        }
    }

    // Show login form
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>FortiFi Logs - Login</title>
        <style>
            body {
                font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
                background: #0f172a;
                color: #e5e7eb;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
            }
            .card {
                background: #020617;
                padding: 24px 28px;
                border-radius: 12px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.5);
                width: 320px;
            }
            h1 {
                margin-top: 0;
                font-size: 20px;
                margin-bottom: 12px;
                text-align: center;
            }
            p {
                font-size: 13px;
                color: #9ca3af;
                text-align: center;
            }
            input[type="password"] {
                width: 100%;
                padding: 8px 10px;
                border-radius: 8px;
                border: 1px solid #374151;
                background: #020617;
                color: #e5e7eb;
                margin-top: 8px;
                font-size: 14px;
            }
            button {
                width: 100%;
                margin-top: 14px;
                padding: 8px 10px;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                background: #22c55e;
                color: #022c22;
                font-weight: 600;
                font-size: 14px;
            }
            .error {
                margin-top: 10px;
                font-size: 13px;
                color: #f97373;
                text-align: center;
            }
            .hint {
                margin-top: 14px;
                font-size: 11px;
                text-align: center;
                color: #6b7280;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <h1>FortiFi Log Viewer</h1>
            <p>Enter the secret password to view logs.</p>
            <form method="post">
                <label for="password" style="font-size:13px;">Password</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Unlock 🔓</button>
            </form>
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <div class="hint">Don’t share this link or password with randos 😏</div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// --------------------------------------
// AUTHENTICATED: SHOW LOG TABLE
// --------------------------------------

// Read log file
$lines = [];
if (file_exists($logFile)) {
    $contents = @file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($contents !== false) {
        // Reverse so newest appears first
        $lines = array_reverse($contents);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FortiFi Logs - Viewer</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #020617;
            color: #e5e7eb;
            margin: 0;
            padding: 0;
        }
        header {
            padding: 16px 24px;
            background: #020617;
            border-bottom: 1px solid #1f2933;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            font-size: 18px;
            margin: 0;
        }
        header .meta {
            font-size: 12px;
            color: #9ca3af;
        }
        header a.logout {
            font-size: 12px;
            color: #f97373;
            text-decoration: none;
            border: 1px solid #f97373;
            padding: 4px 8px;
            border-radius: 999px;
        }
        .container {
            padding: 16px 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 8px;
        }
        th, td {
            padding: 6px 8px;
            border-bottom: 1px solid #111827;
            vertical-align: top;
        }
        th {
            background: #020617;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        tr:nth-child(even) td {
            background: #020617;
        }
        tr:nth-child(odd) td {
            background: #020617;
        }
        .empty {
            font-size: 13px;
            color: #9ca3af;
            margin-top: 16px;
        }
        .pill {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 999px;
            font-size: 10px;
            background: #0f172a;
            color: #9ca3af;
        }
        .ip {
            font-family: "JetBrains Mono", ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 11px;
        }
        .agent, .referer {
            max-width: 320px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .coords {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 11px;
        }
        .top-bar {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
<header>
    <div>
        <h1>FortiFi Visitor Logs</h1>
        <div class="meta">
            Server time: <?php echo date("Y-m-d H:i:s"); ?> (Asia/Kolkata)
        </div>
    </div>
    <div>
        <a class="logout" href="?logout=1">Logout</a>
    </div>
</header>

<div class="container">
    <div class="top-bar">
        <span class="pill">File: visitors.log</span>
        <span class="pill">
            Entries: <?php echo count($lines); ?>
        </span>
        <span class="pill">
            Latest: <?php echo count($lines) ? 'Top row' : 'n/a'; ?>
        </span>
    </div>

    <?php if (empty($lines)): ?>
        <p class="empty">No logs yet. Send your tracking link to someone and then refresh this page 😈</p>
    <?php else: ?>

        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Time</th>
                <th>IP</th>
                <th>Source</th>
                <th>City</th>
				<th>Country</th>
				<th>Latitude / Longitude</th>
				<th>Maps</th>
				<th>User Agent</th>
                <th>Referer</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($lines as $line):
                // Parse "Key: value | Key: value | ..."
                $parts = explode('|', $line);
                $data = [];
                foreach ($parts as $part) {
                    $kv = explode(':', $part, 2);
                    if (count($kv) === 2) {
                        $key = trim($kv[0]);
                        $val = trim($kv[1]);
                        $data[$key] = $val;
                    }
                }

                $timeVal    = isset($data['Time'])    ? $data['Time']    : '';
                $ipVal      = isset($data['IP'])      ? $data['IP']      : '';
                $sourceVal  = isset($data['Source'])  ? $data['Source']  : '';
                $latVal     = isset($data['Lat'])     ? $data['Lat']     : '';
                $lonVal     = isset($data['Lon'])     ? $data['Lon']     : '';
                $cityVal    = isset($data['City'])    ? $data['City']    : '';
				$countryVal = isset($data['Country']) ? $data['Country'] : '';
                $agentVal   = isset($data['Agent'])   ? $data['Agent']   : '';
                $refererVal = isset($data['Referer']) ? $data['Referer'] : '';
                ?>
                <tr>
				    <td><?php echo $i++; ?></td>
				    <td><?php echo htmlspecialchars($timeVal); ?></td>
				    <td class="ip"><?php echo htmlspecialchars($ipVal); ?></td>
                    <td>
					    <?php if ($sourceVal === "browser"): ?>
					        <span style="color:#22c55e;">● Browser</span>
					    <?php else: ?>
					        <span style="color:#f97373;">● IP</span>
					    <?php endif; ?>
					</td>
				    <td><?php echo htmlspecialchars($cityVal); ?></td>
				    <td><?php echo htmlspecialchars($countryVal); ?></td>				
				    <td class="coords">
				        <?php echo htmlspecialchars($latVal); ?><br>
				        <?php echo htmlspecialchars($lonVal); ?>
				    </td>				
				    <td>
				        <?php if ($latVal && $lonVal && $latVal !== "Unknown"): ?>
				            <a href="https://www.google.com/maps?q=<?php echo urlencode($latVal . ',' . $lonVal); ?>" target="_blank">
				                Open 📍
				            </a>
				        <?php else: ?>
				            N/A
				        <?php endif; ?>
				    </td>
				    <td class="agent" title="<?php echo htmlspecialchars($agentVal); ?>">
				        <?php echo htmlspecialchars($agentVal); ?>
				    </td>				
				    <td class="referer" title="<?php echo htmlspecialchars($refererVal); ?>">
				        <?php echo htmlspecialchars($refererVal); ?>
				    </td>
				</tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>
</div>
</body>
</html>
