<?php
require_once "layout/session.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Auth PHP Pro</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #111;
        }

        /* ************** NAVBAR ************** */

        .navbar-custom {
            height: 70px;
            background-color: white;
            border-bottom: 1px solid #ddd;
        }

        .navbar-container {
            max-width: 1050px;
            margin: auto;
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;

            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .logo a {
            color: #333;
            text-decoration: none;
        }

        .logo>a:hover {
            color: #2d7bdc;
        }

        .logo-icon {
            width: 36px;
            height: 36px;

            border-radius: 50%;
            background-color: #2d7bdc;

            color: white;
            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 23px;
            font-weight: bold;
        }

        .logo-icon a {
            color: white;
            text-decoration: none;
        }

        .logo-icon a:hover {
            color: white;
        }

        
        .nav-buttons {
            display: flex;
            gap: 10px;
        }

        .login-btn {
            background-color: #2d7bdc;
            color: white;

            border: 1px solid #2d7bdc;
            border-radius: 25px;

            padding: 9px 25px;
            text-decoration: none;

            transition: 0.2s;
        }

        .login-btn:hover {
            background-color: #2469bd;
            color: white;
        }

        .register-btn {
            background-color: white;
            color: #276bb2;

            border: 2px solid #276bb2;
            border-radius: 25px;

            padding: 8px 25px;
            text-decoration: none;

            transition: 0.2s;
        }

        .register-btn:hover {
            background-color: #276bb2;
            color: white;
        }


        /* ************** HERO ************** */

        .hero {
            background-color: #e8f4ff;

            min-height: 325px;

            text-align: center;

            padding-top: 40px;
        }

        .welcome {
            font-size: 22px;
            margin-bottom: 12px;
        }

        .hero h1 {
            font-size: 35px;
            font-weight: 700;

            margin-bottom: 8px;
        }

        .hero p {
            font-size: 17px;
            line-height: 1.45;

            max-width: 800px;
            margin: auto;
        }

        .hero-buttons {
            margin-top: 18px;

            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .demo-btn {
            background-color: #2d7bdc;
            color: white;

            padding: 10px 30px;

            border-radius: 25px;

            text-decoration: none;

            border: 2px solid #2d7bdc;
        }

        .demo-btn:hover {
            color: white;
            background-color: #2469bd;
        }

        .get-started-btn {
            background-color: white;
            color: #276bb2;

            padding: 9px 30px;

            border-radius: 25px;

            border: 2px solid #276bb2;

            text-decoration: none;
        }

        .get-started-btn:hover {
            background-color: #276bb2;
            color: white;
        }


        /* ************** DEMO CARD ************** */

        .demo-card {
            position: relative;

            width: 625px;
            max-width: 90%;

            margin: -42px auto 0;

            background-color: white;

            border-radius: 10px;

            padding: 18px 20px;

            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.18);

            text-align: left;

            z-index: 2;
        }

        .demo-header {
            display: flex;
            align-items: center;

            gap: 15px;
        }

        .key-icon {
            width: 60px;
            height: 60px;

            background-color: #e8f4ff;

            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 38px;
            color: #438bd5;
        }

        .demo-title {
            font-size: 19px;
            font-weight: bold;

            margin-bottom: 5px;
        }

        .credentials {
            font-size: 14px;
            line-height: 1.6;
        }

        .label {
            background-color: #367fc5;
            color: white;

            padding: 1px 5px;

            border-radius: 2px;

            font-weight: bold;
        }

        .features-title {
            font-size: 16px;
            font-weight: bold;

            margin-top: 10px;
            margin-bottom: 5px;
        }

        .feature {
            font-size: 14px;
            line-height: 1.55;
        }

        .feature i {
            color: #6b879e;
            margin-right: 7px;
        }

        /* ************** DASH BOARD************** */
        .delete-btn {
            display: inline-block;
            color: #dc3545;
            font-size: 20px;
            text-decoration: none;

            transition: all 0.25s ease;
        }

        .delete-btn:hover {
            color: #b02a37;
            transform: scale(1.15) translateY(-2px);
        }

        .edit-btn {
            display: inline-flex;
            width: 38px;
            height: 38px;

            align-items: center;
            justify-content: center;

            color: #0d6efd;
            background-color: #e7f1ff;

            border-radius: 8px;

            text-decoration: none;

            transition: all 0.3s ease;
        }

        .edit-btn:hover {
            color: white;
            background-color: #0d6efd;

            transform: scale(1.1);
        }

        /* ************** TECH STACK ************** */

        .tech-stack {
            text-align: center;

            margin-top: 25px;
        }

        .tech-title {
            font-size: 16px;
            font-weight: bold;

            margin-bottom: 8px;
        }

        .technologies {
            display: flex;
            justify-content: center;
            align-items: center;

            gap: 25px;
        }

        .technology {
            display: flex;
            align-items: center;
            gap: 5px;

            font-size: 15px;
        }

        .php-logo {
            font-weight: bold;
            font-style: italic;

            background-color: #77779b;
            color: white;

            padding: 2px 7px;

            border-radius: 50%;
        }

        .mysql-logo {
            color: #267da4;
            font-weight: bold;
        }

        .bootstrap-logo {
            background-color: #712cf9;
            color: white;

            font-weight: bold;

            padding: 2px 7px;

            border-radius: 4px;

            font-size: 20px;
        }


        /* ************** FOOTER ************** */

        footer {
            max-width: 840px;
            margin: 25px auto 0;

            border-top: 1px solid #ddd;

            padding: 15px 0;

            display: flex;
            justify-content: space-between;

            font-size: 13px;
        }

        .footer-links {
            display: flex;
            gap: 20px;
        }

        .footer-links a {
            color: #52738c;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }


        /* ************** RESPONSIVE ************** */

        @media (max-width: 700px) {

            .navbar-container {
                padding: 0 15px;
            }

            .hero h1 {
                font-size: 27px;
            }

            .hero p {
                padding: 0 15px;
                font-size: 15px;
            }

            .demo-card {
                width: 90%;
            }

            .technologies {
                flex-wrap: wrap;
            }

            footer {
                margin: 25px 20px 0;

                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>


<body>


    <!-- ************** NAVBAR ************** -->

    <nav class="navbar-custom">

        <div class="navbar-container">

            <div class="logo">

                <div class="logo-icon">

                    <a href="index.php">A</a>
                </div>

                <a href="index.php">Auth PHP Pro</a>

            </div>

            <div>
                <?php if ($authorised) { ?>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">

                            <!-- <div class=" d-flex align-items-center"> -->
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= "Hello " . $_SESSION["firstname"] ?>
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

                                <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") { ?>
                                    <li><a class="dropdown-item " href="dashboard.php">
                                            dash board
                                        </a>
                                    </li>
                                <?php } ?>
                                <li><a class="dropdown-item" href="profile.php">profile</a></li>
                                <li><a class="dropdown-item" href="logout.php">logout</a></li>
                                <!--  print_r($_SESSION); ?> -->

                            </ul>

                        </li>

                    </ul>
                <?php } else { ?>
            </div>


            <div class="nav-buttons">

                <a href="login.php" class="login-btn">
                    Log In
                </a>

                <a href="register.php" class="register-btn">
                    Register
                </a>

            </div>
        <?php } ?>
        </div>

    </nav>