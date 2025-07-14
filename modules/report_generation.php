<?php
include_once "../config/database.php";
include_once "../includes/header.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch statistics

$query_unpaid_bills = "SELECT COUNT(*) AS unpaid_bills FROM bills WHERE status = 'Unpaid'";
$result_unpaid_bills = $conn->query($query_unpaid_bills)->fetch_assoc();

$query_revenue = "SELECT SUM(amount) AS total_revenue FROM bills WHERE status = 'Paid'";
$result_revenue = $conn->query($query_revenue)->fetch_assoc();

$query_total_bills = "SELECT COUNT(*) AS total_bills FROM bills";
$result_total_bills = $conn->query($query_total_bills)->fetch_assoc();

$total_revenue = isset($result_revenue['total_revenue']) ? $result_revenue['total_revenue'] : 0;
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Hospital Billing Reports</h2>

    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-primary text-white rounded-3">
                    <i class="fas fa-file-invoice-dollar fa-3x mb-3"></i>
                    <h5 class="card-title">Total Bills</h5>
                    <p class="card-text fs-4"><?= $result_total_bills['total_bills'] ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-danger text-white rounded-3">
                    <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                    <h5 class="card-title">Unpaid Bills</h5>
                    <p class="card-text fs-4"><?= $result_unpaid_bills['unpaid_bills'] ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-success text-white rounded-3">
                    <i class="fas fa-coins fa-3x mb-3"></i>
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text fs-4">₦<?= number_format($total_revenue, 2) ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($success)): ?>
        <div class="alert alert-success mt-4"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger mt-4"><?= $error ?></div>
    <?php endif; ?>
</div>

<?php include_once "../includes/footer.php"; ?>
