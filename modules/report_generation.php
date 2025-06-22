<?php
include_once "../config/database.php";
include_once "../includes/header.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch statistics for reports

// Query for unpaid bills count
$query_unpaid_bills = "SELECT COUNT(*) AS unpaid_bills FROM bills WHERE status = 'Unpaid'";
$result_unpaid_bills = $conn->query($query_unpaid_bills)->fetch_assoc();

// Query for total revenue (sum of paid bills' amount)
$query_revenue = "SELECT SUM(amount) AS total_revenue FROM bills WHERE status = 'Paid'";
$result_revenue = $conn->query($query_revenue)->fetch_assoc();

// Query for total bills count
$query_total_bills = "SELECT COUNT(*) AS total_bills FROM bills";
$result_total_bills = $conn->query($query_total_bills)->fetch_assoc();

// Handle NULL for total_revenue
$total_revenue = isset($result_revenue['total_revenue']) ? $result_revenue['total_revenue'] : 0;
?>

<div class="container mt-5">
    <h2>Report Generation</h2>
    
    <?php if (isset($success)): ?>
        <p class="alert alert-success"><?= $success ?></p>
    <?php elseif (isset($error)): ?>
        <p class="alert alert-danger"><?= $error ?></p>
    <?php endif; ?>

    <h4>Total Bills: <?= $result_total_bills['total_bills'] ?></h4>
    <h4>Unpaid Bills: <?= $result_unpaid_bills['unpaid_bills'] ?></h4>
    
    <!-- Display total revenue -->
    <h4>Total Revenue: ₦<?= number_format($total_revenue, 2) ?></h4>
</div>

<?php include_once "../includes/footer.php"; ?>
