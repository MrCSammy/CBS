<?php
include_once "../config/database.php";
include_once "../includes/header.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch all patients
$patients_query = "SELECT id, name FROM patients";
$patients = $conn->query($patients_query)->fetch_all(MYSQLI_ASSOC);

// Handle bill creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_bill'])) {
    $patient_id = $_POST['patient_id'];
    $service = $_POST['service'];
    $amount = $_POST['amount'];

    $query = "INSERT INTO bills (patient_id, service, amount, total_amount, status) VALUES (?, ?, ?, 0, 'Unpaid')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isd", $patient_id, $service, $amount);

    if ($stmt->execute()) {
        $success = "Bill created successfully!";
    } else {
        $error = "Failed to create bill.";
    }
}

// Handle bill payment update (no direct revenue update here, trigger will handle it)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_payment'])) {
    $bill_id = $_POST['bill_id'];
    $new_status = $_POST['status'];

    $fetch_status_query = "SELECT status FROM bills WHERE id = ?";
    $stmt_fetch = $conn->prepare($fetch_status_query);
    $stmt_fetch->bind_param("i", $bill_id);
    $stmt_fetch->execute();
    $result = $stmt_fetch->get_result()->fetch_assoc();

    if ($result) {
        $current_status = $result['status'];

        if ($current_status === $new_status) {
            $error = "Bill is already marked as $new_status.";
        } else {
            $update_status_query = "UPDATE bills SET status = ? WHERE id = ?";
            $stmt_update = $conn->prepare($update_status_query);
            $stmt_update->bind_param("si", $new_status, $bill_id);

            if ($stmt_update->execute()) {
                $success = "Bill status updated successfully! (Revenue automatically handled)";
            } else {
                $error = "Failed to update bill status.";
            }
        }
    } else {
        $error = "Bill not found.";
    }
}

// Fetch existing bills
$bills_query = "SELECT b.id, p.name AS patient_name, b.service, b.amount, b.total_amount, b.status 
                FROM bills b 
                JOIN patients p ON b.patient_id = p.id
                ORDER BY b.id DESC";
$bills = $conn->query($bills_query)->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Hospital Billing Management</h2>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Bill Creation -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-file-invoice-dollar"></i> Create New Bill
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="patient_id" class="form-label">Select Patient</label>
                            <select class="form-select" id="patient_id" name="patient_id" required>
                                <option value="" disabled selected>Select a patient</option>
                                <?php foreach ($patients as $patient): ?>
                                    <option value="<?= htmlspecialchars($patient['id']) ?>">
                                        <?= htmlspecialchars($patient['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="service" class="form-label">Service</label>
                            <input type="text" class="form-control" id="service" name="service" required>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount (₦)</label>
                            <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0" required>
                        </div>
                        <button type="submit" name="create_bill" class="btn btn-primary w-100">
                            <i class="fas fa-plus-circle"></i> Create Bill
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bill Payment Update -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-edit"></i> Update Bill Payment Status
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="bill_id" class="form-label">Select Bill</label>
                            <select class="form-select" id="bill_id" name="bill_id" required>
                                <option value="" disabled selected>Select a bill</option>
                                <?php foreach ($bills as $bill): ?>
                                    <option value="<?= htmlspecialchars($bill['id']) ?>">
                                        <?= htmlspecialchars($bill['patient_name']) ?> - <?= htmlspecialchars($bill['service']) ?> 
                                        (₦<?= number_format($bill['amount'], 2) ?>) - <?= htmlspecialchars($bill['status']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">New Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Paid">Paid</option>
                            </select>
                        </div>
                        <button type="submit" name="update_payment" class="btn btn-warning w-100">
                            <i class="fas fa-sync-alt"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "../includes/footer.php"; ?>
