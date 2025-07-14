<?php
include_once "../config/database.php";
include_once "../includes/header.php";

// Fetch patients and their billing info (LEFT JOIN to include patients without bills)
$query = "
    SELECT 
        p.id, p.name, p.age, p.gender, p.address,
        IFNULL(b.service, 'No Service Assigned') AS service,
        IFNULL(b.amount, 'N/A') AS amount,
        IFNULL(b.status, 'N/A') AS payment_status
    FROM patients p
    LEFT JOIN bills b ON p.id = b.patient_id
    ORDER BY p.id DESC
";

$patients = $conn->query($query)->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4"><i class="fas fa-users"></i> Patients List</h2>

    <?php if (count($patients) === 0): ?>
        <div class="alert alert-info text-center">
            No patients found.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover shadow rounded-3">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Service</th>
                        <th>Amount (₦)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= htmlspecialchars($patient['name']) ?></td>
                            <td><?= htmlspecialchars($patient['age']) ?></td>
                            <td><?= htmlspecialchars($patient['gender']) ?></td>
                            <td><?= htmlspecialchars($patient['address']) ?></td>
                            <td><?= htmlspecialchars($patient['service']) ?></td>
                            <td>
                                <?= is_numeric($patient['amount']) ? '₦' . number_format($patient['amount'], 2) : $patient['amount'] ?>
                            </td>
                            <td>
                                <?php if ($patient['payment_status'] === 'Paid'): ?>
                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Paid</span>
                                <?php elseif ($patient['payment_status'] === 'Unpaid'): ?>
                                    <span class="badge bg-danger"><i class="fas fa-exclamation-circle"></i> Unpaid</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">N/A</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include_once "../includes/footer.php"; ?>
