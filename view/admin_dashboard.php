<?php
include_once '_partials/_admin_header.php';

// Database connection
$conn = new mysqli('localhost', 'root', '', 'fingerprint');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total staff
$totalStaffResult = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalStaffRow = $totalStaffResult->fetch_assoc();
$totalStaff = $totalStaffRow['total'];

// Fetch total staff with biometrics
$totalBiometricsResult = $conn->query("SELECT COUNT(*) AS total_biometrics FROM users WHERE indexfinger IS NOT NULL AND middlefinger IS NOT NULL");
$totalBiometricsRow = $totalBiometricsResult->fetch_assoc();
$totalBiometrics = $totalBiometricsRow['total_biometrics'];

?>


<!--  Header End -->
<div class="container-fluid">
    <!--  Row 1 -->
    <div class="row">


        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row alig n-items-start">
                        <div class="col-8">
                            <h5 class="card-title mb-9 fw-semibold">Total Staff</h5>
                            <h4 class="fw-semibold mb-3">
                                <?php echo $totalStaff; ?>
                            </h4> <!-- Display total biometrics here -->


                        </div>

                    </div>
                </div>
                <div id="earning"></div>
            </div>
        </div>





        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row alig n-items-start">
                        <div class="col-8">
                            <h5 class="card-title mb-9 fw-semibold"> Total Staff with Biometrics </h5>
                            <h4 class="fw-semibold mb-3">
                                <?php echo $totalBiometrics; ?>
                            </h4> <!-- Display total biometrics here -->


                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div
                                    class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-currency-dollar fs-6"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="earning"></div>
            </div>
        </div>


    </div>
   
</div>


<?php
$conn->close();
include_once '_partials/_footer.php';

?>