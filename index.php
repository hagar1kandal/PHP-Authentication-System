<?php
include "layout/header.php";
?>

<!-- *************** HERO *************** -->

<section class="hero">

    <div class="welcome">
        Welcome
    </div>

    <h1>
        Secure User Management & Authentication System
    </h1>

    <p>
        Welcome to Auth PHP Pro, a complete solution for user
        registration, login, profile management, and an
        administrative panel.
    </p>

    <?php if (!$authorised) { ?>
        <div class="hero-buttons">

            <a href="login.php" class="demo-btn">
                Try Demo
            </a>

            <a href="register.php" class="get-started-btn">
                Get Started
            </a>

        </div>
    <?php } ?>
</section>



<!-- *************** DEMO CARD *************** -->

<div class="demo-card">

    <div class="demo-header">

        <div class="key-icon">
            <i class="bi bi-key"></i>
        </div>


        <div>

            <div class="demo-title">
                Quick Demo Access (Live)
            </div>

            <div class="credentials">

                <div>
                    <span class="label">Admin:</span>
                    admin1@gmail.com / pass: 123456123456mo
                </div>

                <div>
                    <span class="label">User:</span>
                    moon@gmail.com / pass: 1515lklk1515lklk
                </div>

            </div>

        </div>

    </div>


    <div class="features-title">
        Features Overview
    </div>


    <div class="feature">
        <i class="bi bi-list-check"></i>
        Complete CRUD (Create, Read, Update, Delete) for Users
    </div>

    <div class="feature">
        <i class="bi bi-envelope-fill"></i>
        Email Uniqueness Check
    </div>

    <div class="feature">
        <i class="bi bi-shield-check"></i>
        Comprehensive Form Validation
    </div>

    <div class="feature">
        <i class="bi bi-lock-fill"></i>
        Secure Password Hashing (Bcrypt)
    </div>

    <div class="feature">
        <i class="bi bi-shield-check"></i>
        Password Confirmation Validation
    </div>

    <div class="feature">
        <i class="bi bi-lock-fill"></i>
        CSRF Protection
    </div>

    <div class="feature">
        <i class="bi bi-shield-check"></i>
        Current Password Verification for Password Changes
    </div>

    <div class="feature">
        <i class="bi bi-bar-chart-fill"></i>
        Role-Based Access Control
    </div>

    <div class="feature">
        <i class="bi bi-bar-chart-fill"></i>
        Admin User Management (Admin Dashboard)
    </div>

    <div class="feature">
        <i class="bi bi-person-fill"></i>
        User Profile Management
    </div>

    <div class="feature">
        <i class="bi bi-display"></i>
        Modern Responsive Design (Bootstrap 5)
    </div>

</div>



<!-- *************** TECH STACK *************** -->

<section class="tech-stack">

    <div class="tech-title">
        Tech Stack
    </div>


    <div class="technologies">

        <div class="technology">

            <span class="php-logo">
                php
            </span>

            PHP (v8+)

        </div>


        <div class="technology">

            <span class="mysql-logo">
                MySQL
            </span>

        </div>

        <div class="technology">

            <span class="fw-bold">
                PDO
            </span>

        </div>


        <div class="technology">

            <span class="bootstrap-logo">
                B
            </span>

            Bootstrap 5

        </div>

    </div>

</section>

<?php
include "layout/footer.php";
?>