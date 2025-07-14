<?php
include_once "config/database.php";
include_once "includes/header.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch dashboard statistics
$query_patients = "SELECT COUNT(*) AS total_patients FROM patients";
$query_bills = "SELECT COUNT(*) AS total_bills FROM bills";
$query_payments = "SELECT SUM(amount) AS total_revenue FROM bills WHERE status = 'Paid'";

$result_patients = $conn->query($query_patients)->fetch_assoc();
$result_bills = $conn->query($query_bills)->fetch_assoc();
$result_payments = $conn->query($query_payments)->fetch_assoc();
?>

<div class="container mt-5">
    <h1>Welcome to the Hospital Billing System Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Patients</h5>
                    <p class="card-text"><?= $result_patients['total_patients'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Bills</h5>
                    <p class="card-text"><?= $result_bills['total_bills'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text">₦<?= number_format($result_payments['total_revenue'], 2) ?: '0.00' ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>
