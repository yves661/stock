# Server Error - Quick Fix Guide

## 🔍 "Server error. Try again later" - What This Means

This error typically indicates a **backend PHP error** that's preventing the server from processing your request properly.

## 🛠️ **Common Causes & Solutions**

### 1. **Database Connection Failed** (Most Common)
**Problem:** MySQL/XAMPP not running or database doesn't exist
**Solution:**
- Start XAMPP Control Panel
- Start Apache and MySQL services
- Create database named `mini_shop`
- Run `setup.php` to create tables

### 2. **Missing Database Tables**
**Problem:** Database exists but tables are missing
**Solution:**
- Visit `http://localhost/evan%20project/setup.php`
- This will create the admin user and required tables

### 3. **PHP Configuration Issues**
**Problem:** Required PHP extensions missing
**Solution:**
- Check XAMPP PHP has mysqli, session, json extensions
- Restart Apache after changes

### 4. **File Permission Issues**
**Problem:** PHP can't read/write required files
**Solution:**
- Ensure XAMPP has proper permissions
- Check folder permissions in htdocs

### 5. **Syntax Errors in PHP Files**
**Problem:** Code syntax issues causing crashes
**Solution:**
- Check recent file modifications
- Look for PHP error logs in XAMPP

## 🧪 **Diagnostic Steps**

### Step 1: Run Diagnostic
Visit: `http://localhost/evan%20project/diagnostic.php`
This will check:
- ✅ PHP version and extensions
- ✅ Database connection status
- ✅ File permissions
- ✅ Session support

### Step 2: Check XAMPP Services
1. Open XAMPP Control Panel
2. Ensure Apache is running (green)
3. Ensure MySQL is running (green)
4. If stopped, click "Start" on both

### Step 3: Database Setup
1. Click "Admin" on MySQL in XAMPP
2. Create database named `mini_shop`
3. Import `database/schema.sql` if needed
4. Visit `setup.php` to create admin user

### Step 4: Test Basic PHP
Create test file `test.php`:
```php
<?php
echo "PHP is working!";
phpinfo();
?>
```
Visit `http://localhost/evan%20project/test.php`

## 🚨 **Immediate Actions**

### 1. Restart Services
- Stop Apache and MySQL in XAMPP
- Wait 10 seconds
- Start MySQL first, then Apache

### 2. Clear Browser Cache
- Press Ctrl+F5
- Clear browser data
- Try incognito mode

### 3. Check Error Logs
- XAMPP → Apache → Error log
- Look for specific error messages
- Note file/line numbers mentioned

## 📞 **If Still Not Working**

### Check These Files:
1. **`includes/db.php`** - Database credentials
2. **`includes/init.php`** - Session initialization  
3. **`api/login.php`** - Login endpoint
4. **`api/register.php`** - Registration endpoint

### Default Credentials After Setup:
- Username: `admin`
- Password: `password123`

---

**Most Likely Fix:** Start XAMPP services and run `setup.php` to initialize the database properly.
