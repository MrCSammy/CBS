<?php
include_once "../config/database.php";
include_once "../includes/header.php";

$message = "";

// Handle Delete
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    // Delete patient and associated bills
    $conn->query("DELETE FROM bills WHERE patient_id = $delete_id");
    $conn->query("DELETE FROM patients WHERE id = $delete_id");

    $message = "<div class='alert alert-success'>Patient deleted successfully.</div>";
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_patient'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE patients SET name=?, age=?, gender=?, address=? WHERE id=?");
    $stmt->bind_param("sissi", $name, $age, $gender, $address, $id);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Patient updated successfully.</div>";
    } else {
        $message = "<div class='alert alert-danger'>Failed to update patient.</div>";
    }
}

// Fetch Patients
$patients = $conn->query("SELECT * FROM patients ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4"><i class="fas fa-user-edit"></i> Manage Patients</h2>

    <?= $message ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow rounded-3">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Actions</th>
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
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $patient['id'] ?>">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <!-- Delete Button -->
                            <a href="?delete=<?= $patient['id'] ?>" onclick="return confirm('Are you sure you want to delete this patient? This will also delete their bills.')" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </a>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $patient['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $patient['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?= $patient['id'] ?>">Edit Patient</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $patient['id'] ?>">
                                            <div class="mb-3">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($patient['name']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Age</label>
                                                <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($patient['age']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Gender</label>
                                                <select name="gender" class="form-select" required>
                                                    <option value="Male" <?= $patient['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                                    <option value="Female" <?= $patient['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Address</label>
                                                <textarea name="address" class="form-control" required><?= htmlspecialchars($patient['address']) ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" name="update_patient" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once "../includes/footer.php"; ?>
