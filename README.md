# FortiFi Location Logger

A small PHP-based location logger project I made to learn how:

- browser geolocation works
- IP logging works
- basic analytics systems work
- simple intrusion detection concepts work

It collects:
- 🌍 Approximate IP location
- 📍 Browser location (if user allows it)
- 💻 Device/browser info
- 🕒 Visitor logs
- 🚨 Simple suspicious activity checks

Nothing super advanced, mostly a learning + experimentation project.

---

# ⚠️ Disclaimer

This project was made for:
- learning purposes
- cybersecurity practice
- analytics experimentation
- understanding browser APIs

Please don’t use this for:
- phishing
- stalking
- harmful tracking
- creepy stuff 😭

If you deploy this publicly, it’s better to:
- inform users
- respect privacy
- follow local laws

---

# 🧠 Things To Know

Location is NOT perfectly accurate.

Accuracy depends on:
- mobile or desktop
- GPS
- browser permissions
- VPN usage
- internet/network

Important:
- browser location needs permission
- IP location is only approximate
- some browsers block tracking features

---

# ✨ Features

- PHP visitor logging
- Browser geolocation
- IP fallback tracking
- SQLite database
- Simple dashboard
- Log viewer
- Basic detection system
- Works on free hosting

---

# 📁 Project Structure

```bash
htdocs/
│
├── dashboard/
│   ├── index.html
│   └── app.js
│
├── private_logs/
│   ├── .htaccess
│   └── visitors.log
│
├── alerts.php
├── api.php
├── db.php
├── detect.php
├── log.php
├── logs.db
├── test.php
└── viewer.php
```

---

# ⚙️ Setup Guide

ok so dont rush this part 😭

---

## 🧩 Step 1 — Create Hosting

Go to:

https://infinityfree.net

Create:
- account
- hosting
- free domain

Example:

```bash
fortifi.great-site.net
```

Wait for activation.

---

## 🧩 Step 2 — Open File Manager

Open:

```bash
htdocs/
```

This is where your website files go.

---

## 🧩 Step 3 — Upload Files

Upload all project files into:

```bash
htdocs/
```

Final structure should look similar to the screenshots above.

---

## 🧩 Step 4 — Protect Logs

Inside:

```bash
private_logs/
```

Create:

```bash
.htaccess
```

Paste:

```apache
Deny from all
```

This blocks direct browser access to logs.

---

## 🧩 Step 5 — Configure Redirect

Open:

```bash
log.php
```

Find:

```php
header("Location: https://shvtheamigo.github.io/FortiFi/");
```

Replace with your own link if needed.

---

## 🧩 Step 6 — Test Logger

Open:

```bash
https://yourdomain/log.php
```

Allow location permission.

If everything works:
- data gets logged
- redirect happens automatically

---

## 🧩 Step 7 — Open Viewer

Open:

```bash
https://yourdomain/viewer.php
```

You should see logs there.

---

## 🧩 Step 8 — Open Dashboard

Open:

```bash
https://yourdomain/dashboard/
```

Dashboard should load analytics stuff from the backend.

---

# 🧪 Example Log

```bash
Time: 2026-05-14
IP: xxx.xxx.xxx.xxx
City: Hyderabad
Latitude: xx.xxxx
Longitude: xx.xxxx
Accuracy: 20m
Device: Android Chrome
```

---

# ⚠️ Common Problems

## ❌ Location Wrong

Usually because:
- VPN
- desktop device
- permission denied
- GPS off

---

## ❌ Viewer Empty

Check:
- PHP enabled
- correct file paths
- logs.db exists
- permissions

---

## ❌ Dashboard Broken

Check:
- `api.php`
- browser console
- JS errors
- fetch URLs

---

# 🧠 Tips

- Test on mobile for better accuracy
- Keep GPS ON
- HTTPS helps a lot
- Don’t expect exact location always

---

# 🚀 Future Improvements

Things I might add later:

- live visitor tracking
- better dashboard charts
- map visualization
- admin login
- threat scoring
- export logs
- better intrusion detection

---

# 🧑‍💻 Why I Made This

Mostly because I wanted to learn:
- PHP backend stuff
- browser APIs
- logging systems
- simple cybersecurity concepts
- dashboards and analytics

And honestly it was fun to build 😭

---

# 🏁 Done

If it works:
nice 🔥

If it breaks:
debug slowly 😭

Most issues are usually:
- wrong paths
- missing permissions
- hosting limitations
- browser blocking location
