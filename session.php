<?php
session_start(); // Start session
if (!isset($_SESSION['staff_id'])) {
    // If session is not set, redirect to login
    header("Location: index.php");
    exit();
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>