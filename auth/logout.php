<?php
include('../db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Session Flash and Logout
session_destroy();
header("Location: login.php");
exit();

?>