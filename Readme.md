Digital Business Card Generator Setup Instructions

1. Requirements:
- PHP 7.4+
- MySQL 5.7+
- Web server (Apache/Nginx)

2. Installation:
- Create database using the provided SQL file (sql/database.sql)
- Update database credentials in public/php/config.php
- Place all files in your web server's document root

3. Features:
- User registration and login
- Business card creation with real-time preview
- Data persistence
- Responsive design
- Color customization

4. Security Considerations:
- Change database credentials in production
- Store sensitive data in environment variables
- Add CSRF protection
- Implement rate limiting