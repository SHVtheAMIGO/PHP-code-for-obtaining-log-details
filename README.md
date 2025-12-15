📍 FortiFi Visitor Logger & Redirect System

A lightweight PHP-based visitor logging system that captures **IP address**, **approximate or precise location (latitude & longitude)**, and **basic device info**, then **redirects users** to a target website seamlessly.

Designed for **learning, analytics, and security experimentation**.

---

## ✨ Features

* 🌐 Logs visitor **IP address**
* 📍 Captures **latitude & longitude**

  * Uses **browser geolocation** when permission is granted
  * Falls back to **IP-based location** if denied or unavailable
* 🕒 Logs time in **IST (Asia/Kolkata)**
* 💻 Records **User-Agent** (browser & device info)
* 🔁 Automatically **redirects** visitors to a target site
* 🔐 Includes a **password-protected log viewer**
* 🕶️ Logs stored **outside the public web root** for stealth & safety

---

## 🧠 How It Works (Flow)

1. User visits `log.php`
2. Browser is asked for location permission
3. If **allowed**:

   * Precise latitude & longitude are captured
4. If **denied or fails**:

   * Approximate location is obtained using IP
5. Visitor data is logged securely on the server
6. User is redirected to the main website (GitHub Pages or any URL)

No visible delay, no user-facing errors.

---

## 📁 Project Structure

```text
/htdocs
 ├── log.php        # Main logger + redirect handler
 ├── viewer.php     # Password-protected log viewer
/logs
 └── visitors.log   # Stored logs (not publicly accessible)
```

---

## ⚙️ Requirements

* PHP-enabled hosting (tested on InfinityFree)
* PHP 7.x or newer
* Outbound HTTP requests enabled (for IP geolocation API)

> ⚠️ This will **not work on GitHub Pages alone** (PHP is not supported there).

---

## 🔧 Configuration

### 1️⃣ Set Redirect Target

In `log.php`, update:

```php
header("Location: https://shvtheamigo.github.io/FortiFi/");
```

Replace with your desired destination URL.

---

### 2️⃣ Set Timezone (IST)

Already configured:

```php
date_default_timezone_set('Asia/Kolkata');
```

Change if needed.

---

### 3️⃣ Set Viewer Password

In `viewer.php`, update:

```php
const VIEW_PASSWORD = 'YourStrongPasswordHere';
```

Choose a strong password and **do not share it**.

---

## 🔐 Log Viewer

Access the log viewer at:

```text
https://yourdomain.com/viewer.php
```

Features:

* Password-protected login
* Newest logs shown first
* Clean table view
* Logout option

---

## 📄 Log Format Example

```text
Time: 2025-12-07 14:42:10 | IP: 123.45.67.89 | Lat: 17.6868 | Lon: 83.2185 | Agent: Mozilla/5.0 ... | Referer: Direct / No referer
```

---

## 📌 Notes on Location Accuracy

* **Mobile devices with GPS** → usually very accurate
* **Desktops / laptops** → may be approximate (Wi-Fi / ISP based)
* **VPNs / proxies** → location may be inaccurate

This is expected behavior and not a bug.

---

## ⚠️ Privacy & Ethics Notice

This project is intended for:

* Educational use
* Basic analytics
* Security learning
* Personal projects

Do **not** use this system for:

* Phishing
* Deception
* Harassment
* Unauthorized tracking

If used publicly, consider adding a **privacy notice** stating that basic analytics are collected.

---

## 🚀 Future Improvements (Optional)

* Add city/country name resolution
* Add Google Maps links for coordinates
* Add source tagging (`?src=instagram`)
* Add search/filter in log viewer
* Export logs as CSV

---

## 🧑‍💻 Author

Built with curiosity, debugging pain, and caffeine ☕
By **Mate** — learning by building.

---

If you want, I can:

* Convert this into a **polished GitHub README with badges**
* Add a **LICENSE** file
* Or tailor it for a **college mini-project submission**

Just say the word 👀🔥
