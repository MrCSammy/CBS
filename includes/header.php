<?php
// Base URL configuration
$base_url = '/CBS/'; // Adjust if your project folder is different

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get the current script name
$current_file = basename($_SERVER['PHP_SELF']);

// Allow access only to login, register, and logout pages if not logged in
$public_pages = ['login.php', 'register.php', 'index.php'];

// Check login status
if (!isset($_SESSION['user_id']) && !in_array($current_file, $public_pages)) {
    header("Location: " . $base_url . "login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital Billing System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="<?= $base_url ?>index.php">Hospital Billing</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>modules/patient_registration.php">New Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>modules/bill_creation.php">Bills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>modules/report_generation.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>modules/view_patients.php">Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>modules/manage_patients.php">Manage Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
