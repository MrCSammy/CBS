<?php
// Include configuration and session files
include_once "config/database.php";
include_once "includes/header.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect unauthenticated users to the login page
    header("Location: login.php");
    exit();
}

// Fetch dashboard statistics
$query_patients = "SELECT COUNT(*) AS total_patients FROM patients";
$query_bills = "SELECT COUNT(*) AS total_bills FROM bills";
$query_payments = "SELECT SUM(amount) AS total_revenue FROM bills WHERE status = 'Paid'"; // Ensure the correct condition

$result_patients = $conn->query($query_patients)->fetch_assoc();
$result_bills = $conn->query($query_bills)->fetch_assoc();
$result_payments = $conn->query($query_payments)->fetch_assoc();
?>

<div class="container mt-5">
    <h1>Welcome to the Hospital Billing System</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Total Patients</h5>
                    <p><?= $result_patients['total_patients'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Total Bills</h5>
                    <p><?= $result_bills['total_bills'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <p>₦<?= number_format($result_payments['total_revenue'], 2) ?: '0.00' ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>
