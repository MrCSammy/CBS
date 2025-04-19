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

// Fetch Bill Details and Patient Info
if (isset($_GET['bill_id'])) {
    $bill_id = $_GET['bill_id'];

    $bill_query = "SELECT b.id, pt.name AS patient_name, b.total_amount, b.payment_status, b.date 
                   FROM bills b 
                   JOIN patients pt ON b.patient_id = pt.id 
                   WHERE b.id = '$bill_id'";
    $bill_result = $conn->query($bill_query);
    $bill = $bill_result->fetch_assoc();

    // Fetch Bill Services
    $services_query = "SELECT s.name AS service_name, bs.amount 
                       FROM bill_services bs 
                       JOIN services s ON bs.service_id = s.id 
                       WHERE bs.bill_id = '$bill_id'";
    $services_result = $conn->query($services_query);

    // Fetch Payment Details
    $payments_query = "SELECT p.payment_amount, p.payment_date 
                       FROM payments p 
                       WHERE p.bill_id = '$bill_id'";
    $payments_result = $conn->query($payments_query);
}

// Generate Invoice (HTML view for now)
if ($bill) {
    echo "<html>
            <head>
                <title>Invoice for Bill #{$bill['id']}</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { width: 80%; margin: 0 auto; }
                    .invoice-header, .invoice-body { margin-bottom: 20px; }
                    .invoice-header h1 { margin: 0; }
                    .invoice-body table { width: 100%; border-collapse: collapse; }
                    .invoice-body th, .invoice-body td { padding: 8px; border: 1px solid #ddd; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='invoice-header'>
                        <h1>Invoice</h1>
                        <p>Bill #{$bill['id']} | Date: {$bill['date']}</p>
                        <p>Patient: {$bill['patient_name']}</p>
                    </div>

                    <div class='invoice-body'>
                        <h3>Services Rendered</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>";

                            while ($service = $services_result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$service['service_name']}</td>
                                        <td>₦{$service['amount']}</td>
                                    </tr>";
                            }

        echo "</tbody>
            </table>

            <h3>Payments Made</h3>
            <table>
                <thead>
                    <tr>
                        <th>Payment Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>";

                while ($payment = $payments_result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$payment['payment_date']}</td>
                            <td>₦{$payment['payment_amount']}</td>
                        </tr>";
                }

        echo "</tbody>
            </table>

            <h3>Total Amount: ₦{$bill['total_amount']}</h3>
            <h3>Payment Status: {$bill['payment_status']}</h3>
        </div>
    </div>
</body>
</html>";
}
?>
