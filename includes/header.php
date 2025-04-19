<?php
// Ensure session is started to manage user state
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Billing System</title>
    <!-- Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href=".index.php">Hospital Billing System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>modules/patient_registration.php">Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>modules/bill_creation.php">Bills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>modules/report_generation.php">Reports</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $base_url ?>logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $base_url ?>login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $base_url ?>register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </nav>
    <div class="container mt-4">