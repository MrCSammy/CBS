<?php
// Database Connection
$host = "localhost";
$user = "root";
$password = "";
$database = "hospital_billing";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $service_name = $_POST['service_name'];
    $cost = $_POST['cost'];

    $sql = "INSERT INTO services (service_name, cost) VALUES ('$service_name', '$cost')";

    if ($conn->query($sql) === TRUE) {
        $message = "Service added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch Services
$services = $conn->query("SELECT * FROM services");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Service Management</h2>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="service_name" class="form-label">Service Name</label>
                <input type="text" name="service_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="cost" class="form-label">Cost</label>
                <input type="number" name="cost" class="form-control" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Service</button>
        </form>

        <h3>Existing Services</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($services->num_rows > 0): ?>
                    <?php while ($row = $services->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['service_name']; ?></td>
                            <td><?php echo $row['cost']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No services available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
