<?php
include_once "../config/database.php";
include_once "../includes/header.php";

// Fetch all unpaid bills
$bills_query = "SELECT id, patient_id, service, amount FROM bills WHERE status = 'Unpaid'";
$bills = $conn->query($bills_query)->fetch_all(MYSQLI_ASSOC);

// Handle payment recording
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bill_id = $_POST['bill_id'];
    $payment_amount = $_POST['payment_amount'];

    $query_payment = "INSERT INTO payments (bill_id, payment_amount) VALUES (?, ?)";
    $query_update_bill = "UPDATE bills SET status = 'Paid' WHERE id = ?";

    $stmt_payment = $conn->prepare($query_payment);
    $stmt_update_bill = $conn->prepare($query_update_bill);

    $stmt_payment->bind_param("id", $bill_id, $payment_amount);
    $stmt_update_bill->bind_param("i", $bill_id);

    if ($stmt_payment->execute() && $stmt_update_bill->execute()) {
        $success = "Payment recorded successfully!";
    } else {
        $error = "Failed to record payment.";
    }
}
?>

<div class="container">
    <h2>Record Payment</h2>
    <?php if (isset($success)): ?>
        <p class="alert alert-success"><?= $success ?></p>
    <?php elseif (isset($error)): ?>
        <p class="alert alert-danger"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="bill_id" class="form-label">Bill</label>
            <select class="form-select" id="bill_id" name="bill_id" required>
                <?php foreach ($bills as $bill): ?>
                    <option value="<?= $bill['id'] ?>">Service: <?= $bill['service'] ?> | Amount: ₦<?= $bill['amount'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="payment_amount" class="form-label">Payment Amount (₦)</label>
            <input type="number" class="form-control" id="payment_amount" name="payment_amount" required>
        </div>
        <button type="submit" class="btn btn-primary">Record Payment</button>
    </form>
</div>

<?php include_once "../includes/footer.php"; ?>
