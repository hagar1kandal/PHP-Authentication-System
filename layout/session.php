<?php

session_start();

$authorised = false;

if (isset($_SESSION["email"])) {
    $authorised = true;
}
?>