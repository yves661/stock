# Mini Shop Manager - Setup Guide

## 🚀 Quick Setup Instructions

### 1. Database Setup
1. Create a MySQL database named `mini_shop`
2. Import the database schema:
   ```sql
   -- Run the contents of database/schema.sql in your MySQL client
   ```

### 2. Configure Database Connection
Edit `includes/db.php` if needed:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Your MySQL password
define('DB_NAME', 'mini_shop');
```

### 3. Create Admin User
Visit `http://localhost/evan%20project/setup.php` in your browser to create the default admin user:
- **Username:** admin
- **Password:** password123

⚠️ **Important:** Change the default password in production!

### 4. Start the Application
Using XAMPP, the project should be accessible at:
```
http://localhost/evan%20project/
```

Or using PHP's built-in server:
```bash
cd "c:\xampp\htdocs\evan project"
php -S localhost:8000
```

## 🔧 Features Connected

### ✅ Fixed Issues:
1. **Navigation Links** - All HTML references converted to PHP
2. **Database Connection** - Proper MySQL connectivity established
3. **Session Management** - Login/logout functionality working
4. **JavaScript Integration** - All JS files properly connected
5. **Authentication** - Protected pages require login

### 🌐 Multi-Language Support
- English (Default)
- Français (French)
- Kinyarwanda

### 📱 Responsive Design
- Bootstrap 5.3.2
- Mobile-friendly interface
- Modern UI components

## 🛠️ File Structure

```
evan project/
├── api/                    # Backend API endpoints
├── css/styles.css         # Stylesheets
├── js/                    # JavaScript files
├── includes/              # PHP includes (database, init)
├── database/              # Database schema
├── index.php              # Homepage
├── login.php              # Login page
├── dashboard.php          # Main dashboard
├── inventory.php          # Inventory management
├── sales.php              # Sales transactions
├── reports.php            # Sales reports
├── settings.php           # Settings page
├── features.php           # Features page
├── pricing.php            # Pricing page
├── signup.php             # User registration
└── setup.php              # Initial setup script
```

## 🔐 Default Credentials
- **Username:** admin
- **Password:** password123

## 🚨 Security Notes
1. Change default admin password immediately
2. Use HTTPS in production
3. Validate all user inputs
4. Implement proper error logging
5. Regular database backups

## 📞 Support
If you encounter issues:
1. Check database connection in `includes/db.php`
2. Verify PHP error logs
3. Ensure all file permissions are correct
4. Test with browser developer tools

---

**Project Status:** ✅ All errors fixed and fully connected!
