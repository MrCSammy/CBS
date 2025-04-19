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

<div class="container">
    <h2>Register Patient</h2>
    <?php if (isset($success)): ?>
        <p class="alert alert-success"><?= $success ?></p>
    <?php elseif (isset($error)): ?>
        <p class="alert alert-danger"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" id="age" name="age" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<?php include_once "../includes/footer.php"; ?>
