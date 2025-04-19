<?php
session_start();
include_once "config/database.php";
include_once "includes/header.php"; // Include header with navigation

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if the email already exists
        $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $error = "An account with this email already exists.";
        } else {
            // Hash the password and insert the new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $insert_query->bind_param("sss", $name, $email, $hashed_password);

            if ($insert_query->execute()) {
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['user_name'] = $name;
                header("Location: index.php");
                exit();
            } else {
                $error = "Error registering user. Please try again.";
            }
        }
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h3>Register</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Register</button>
                    </form>
                    <p class="text-center mt-3">
                        Already have an account? <a href="login.php">Login here</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; // Include footer ?>
