# FortiFi Location Logger

This is a simple php based visitor logger that logs ip, location and some other stuff.

---

## ⚙️ Requirements

* free hosting (like infinityfree)
* github pages (optional)
* basic brain (optional but helpful lol)

---

## 🚀 Setup Guide

### Step 1: Create hosting account

go to:
https://infinityfree.net

create account and create a free domain (like something.epizy.com or great-site.net)

---

### Step 2: Open File Manager

* go to your domain
* open **htdocs/** folder

---

### Step 3: Create files

create these files:

* `log.php`
* `viewer.php`

copy paste the php code into them

---

### Step 4: Create logs folder

inside `htdocs/`:

create folder:

```
private_logs
```

inside it create:

```
visitors.log
```

(optional, it will auto create but better to do it manually)

---

### Step 5: Protect logs

inside `private_logs/` create:

```
.htaccess
```

paste:

```
Deny from all
```

this prevents direct access (kinda important)

---

### Step 6: Test logging

open:

```
https://yourdomain/log.php
```

allow location

you should get redirected to your site

---

### Step 7: Check logs

open:

```
https://yourdomain/viewer.php
```

enter password

you should see entries

---

## ⚠️ Notes

* sometimes location is not exact (thats normal)
* mobile gps works better than laptop
* ip based location is kinda meh

---

## 📌 Example Log

```
Time: 2026-04-22 | Source: browser | IP: xxx | City: Kakinada | Lat: 16.xxxx | Lon: 82.xxxx
```

---

## 🧠 Small Issues you may face

* logs not showing → check path
* location wrong → user denied gps
* multiple logs → refresh issue (fixed with session)

---

## 🏁 Done

if it works congrats
if not... debug again 😭

---
