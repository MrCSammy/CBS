<?php
include_once "includes/header.php";
?>

<div class="container mt-5">

    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Hospital Billing System</h1>
        <p class="lead">A simple and efficient way to manage patients, create bills, and track hospital revenue.</p>
    </div>

    <!-- Carousel -->
    <div id="hospitalCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/img/hospitaloverview.png" class="d-block w-100" alt="Hospital Overview" style="height: 400px; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                    <h5>Manage Patients Seamlessly</h5>
                    <p>Register and track patients with ease.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/Invoicing-Billing-Software.png" class="d-block w-100" alt="Billing System" style="height: 400px; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                    <h5>Automated Billing</h5>
                    <p>Create and manage hospital bills effortlessly.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/report.jpg" class="d-block w-100" alt="Reports" style="height: 400px; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                    <h5>Generate Reports</h5>
                    <p>Track revenue, unpaid bills, and statistics in real time.</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#hospitalCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#hospitalCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Feature Cards -->
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-user-plus fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Patient Management</h5>
                    <p class="card-text">Easily register patients, view records, and manage their information securely.</p>
                    <a href="<?= $base_url ?>modules/patient_registration.php" class="btn btn-outline-primary">Get Started</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-invoice-dollar fa-3x mb-3 text-success"></i>
                    <h5 class="card-title">Billing & Payments</h5>
                    <p class="card-text">Generate bills, mark payments, and track financial transactions easily.</p>
                    <a href="<?= $base_url ?>modules/bill_creation.php" class="btn btn-outline-success">Create Bill</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-3x mb-3 text-warning"></i>
                    <h5 class="card-title">Revenue & Reports</h5>
                    <p class="card-text">View detailed reports of payments, revenue, and outstanding bills.</p>
                    <a href="<?= $base_url ?>modules/report_generation.php" class="btn btn-outline-warning">View Reports</a>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="mt-5 text-center">
        <h3>About This System</h3>
        <p class="lead">This Hospital Billing System is designed to simplify hospital operations. Whether you are managing patients, creating bills, or generating reports, our platform provides an easy-to-use solution.</p>
    </div>

</div>

<?php include_once "includes/footer.php"; ?>
