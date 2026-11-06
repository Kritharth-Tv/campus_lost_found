# Campus Lost & Found Management System

## Project Overview

The Campus Lost & Found Management System is a web-based application developed to help students manage lost and found items within a college campus.

It provides a centralized platform where administrators can record, search, update and manage information about lost and found belongings.

## Objectives

- To make reporting lost and found items easier.
- To maintain organized records of reported items.
- To help identify and recover missing belongings.
- To reduce the manual work involved in managing lost and found items.

## Technologies Used

- **Frontend:** HTML, CSS
- **Backend:** PHP
- **Database:** MySQL
- **Development Environment:** XAMPP
- **Code Editor:** Visual Studio Code

## Features

1. **Admin Login:** Secure login for administrators.
2. **Dashboard:** Displays total, lost, found and returned item statistics.
3. **Report Items:** Add details about lost and found belongings.
4. **View Items:** View and search reported items.
5. **Edit Items:** Update item information.
6. **Delete Items:** Remove unwanted records.
7. **Return Items:** Mark recovered items as returned.
8. **Change Password:** Allows administrators to update their password.

## Project Structure

```text
campus_lost_found/
│
├── index.php
├── db.php
├── db.example.php
├── add_item.php
├── view_items.php
├── edit_item.php
├── delete_item.php
├── return_item.php
├── login.php
├── logout.php
├── auth.php
├── change_password.php
├── style.css
└── README.md
```

## Installation and Setup

1. Install XAMPP on your computer.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Copy the project folder into the `htdocs` directory.
4. Open phpMyAdmin in your browser.
5. Create a database named `campus_lost_found`.
6. Create the required `items` and `admins` tables.
7. Configure your database connection in `db.php`.
8. Create an administrator account with a securely hashed password.
9. Open the following address in your browser:

`http://localhost/campus_lost_found/`

## Future Enhancements

- Student registration and login.
- Image uploading for lost and found items.
- Email notifications.
- Improved search and filtering options.
- Online deployment for access from anywhere.

## Author

Developed as an academic project using PHP and MySQL.

## Project Repository

GitHub: https://github.com/Kritharth-Tv/campus_lost_found