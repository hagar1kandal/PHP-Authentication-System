# PHP Authentication System

A secure user authentication and management system built with Native PHP, MySQL, and Bootstrap 5.

The project demonstrates authentication, authorization, CRUD operations, session management, and common web security practices in a practical PHP application.

## Features

### Authentication & Validation

* User Registration and Login
* Secure Password Hashing using Bcrypt 
* Password Confirmation Validation
* Comprehensive Form Data Validation
* Email Uniqueness Check
* Session-Based Authentication
* Current Password Verification before Password Changes 
* CSRF Attack Prevention
* PDO Prepared Statements to help prevent SQL Injection

### User & Admin Management

* Users can update their own profile information without being required to change their password.
* Users must provide their current password when choosing to change their password.
* Users can only edit their own profile information.
* Administrators can update their own profile information.
* Administrators can manage other users' information and set a new password without requiring the user's current password.
* Complete User CRUD Operations
* Role-Based Access Control
* Admin Dashboard

### User Features

* View Profile
* Edit Profile Information
* Change Password
* Access features based on assigned role

### Admin Features

* View All Users
* Add Users
* Edit User Information
* Delete Users
* Reset User Passwords
* Manage User Accounts
* Access Admin Dashboard

## Tech Stack

* **PHP 8+**
* **MySQL**
* **PDO**
* **Bootstrap 5**
* **HTML5**
* **CSS3**

## Live Demo

[Try the Live Demo](https://phpauth.wuaze.com)

## Demo Access

The application includes separate Admin and User demo accounts for testing the available features.

### Admin Account
- Email: `admin1@gmail.com`
- Password: `123456123456mo`

### User Account
- Email: `moon@gmail.com`
- Password: `1515lklk1515lklk`

> **Note:** The demo credentials provided above are for testing purposes only. Please do not reuse these passwords for real accounts or other services.

## Project Structure

```text
PHP-Authentication-System/
│
├── connection/
│   └── config.php
│
├── layout/
│   ├── footer.php
│   ├── header.php
│   └── session.php
│
├── add_user.php
├── dashboard.php
├── delete_user.php
├── edit_profile.php
├── index.php
├── login.php
├── logout.php
├── profile.php
├── README.md
└── register.php 

```

## Installation

1. Clone the repository.
2. Move the project to the XAMPP `htdocs` directory.
3. Create the required MySQL database.
4. Configure the database connection.
5. Start Apache and MySQL from XAMPP.
6. Open the project in your browser.

## Database

The application uses MySQL for storing user accounts and application data.

A sample database file is included in the repository with demo data for testing purposes. No real user data is included.

## Purpose

This project was developed to practice backend web development using Native PHP, including authentication, authorization, CRUD operations, database interaction, sessions, validation, and web security fundamentals.