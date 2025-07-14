<?php
include_once "../config/database.php";
include_once "../includes/header.php";

// Handle patient registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    $query = "INSERT INTO patients (name, age, gender, address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siss", $name, $age, $gender, $address);

    if ($stmt->execute()) {
        $success = "Patient registered successfully!";
    } else {
        $error = "Failed to register patient.";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center">
                    <h4><i class="fas fa-user-plus"></i> Patient Registration</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php elseif (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter patient's full name" required>
                        </div>

                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" placeholder="Enter age" required>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="" disabled selected>Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter home address" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check-circle"></i> Register Patient
                        </button>
                    </form>
                </div>
                <div class="card-footer text-muted text-center">
                    <small>All patient data is stored securely.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "../includes/footer.php"; ?>
