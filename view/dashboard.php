<?php
include_once '_partials/_header.php';

// Include database connection
require_once '../backend/php/connection.php';

// Assuming the user's ID is stored in session
$user_id = $_SESSION['user_id'];

// Query to calculate total hours worked in the current month
$sql = "SELECT SUM(TIMESTAMPDIFF(SECOND, sign_in_time, sign_out_time)) AS total_seconds
        FROM attendance
        WHERE user_id = ? 
          AND MONTH(attendance_date) = MONTH(CURDATE()) 
          AND YEAR(attendance_date) = YEAR(CURDATE())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $total_hours = 0;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_seconds = $row['total_seconds'];
        $total_hours = $total_seconds ? round($total_seconds / 3600, 2) : 0; // Convert seconds to hours
    }
}

// Query to get the total hours worked this week
$sql_week = "SELECT SUM(TIMESTAMPDIFF(SECOND, sign_in_time, sign_out_time)) AS total_seconds
             FROM attendance
             WHERE user_id = ? 
               AND YEARWEEK(attendance_date, 1) = YEARWEEK(CURDATE(), 1)"; // Filters the current week

$stmt_week = $conn->prepare($sql_week);
$stmt_week->bind_param("i", $user_id);
if ($stmt_week->execute()) {
    $result_week = $stmt_week->get_result();
    $total_hours_week = 0;

    if ($result_week->num_rows > 0) {
        $row_week = $result_week->fetch_assoc();
        $total_seconds_week = $row_week['total_seconds'];
        $total_hours_week = $total_seconds_week ? round($total_seconds_week / 3600, 2) : 0; // Convert seconds to hours
    }
}

// Query to get number of days present this month
$sql_present = "SELECT COUNT(DISTINCT attendance_date) AS days_present
                FROM attendance
                WHERE user_id = ? 
                  AND sign_in_time IS NOT NULL 
                  AND sign_out_time IS NOT NULL
                  AND MONTH(attendance_date) = MONTH(CURDATE()) 
                  AND YEAR(attendance_date) = YEAR(CURDATE())";

$stmt_present = $conn->prepare($sql_present);
$stmt_present->bind_param("i", $user_id);
if ($stmt_present->execute()) {
    $result_present = $stmt_present->get_result();
    $days_present = 0;

    if ($result_present->num_rows > 0) {
        $row_present = $result_present->fetch_assoc();
        $days_present = $row_present['days_present'];
    }
}

$stmt_present->close();
$stmt_week->close();
$stmt->close();
$conn->close();
?>

<!--  Header End -->
<div class="container-fluid">
    <!--  Row 1 -->
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-start">
                                <div class="col-8">
                                    <h5 class="card-title mb-9 fw-semibold">Total Hours Worked This Month</h5>
                                    <?php echo $total_hours > 0 ? $total_hours . ' Hours' : '-'; ?>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-clock fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <!-- Monthly Earnings -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold">Number of Days Present this Month</h5>
                                        <h4 class="fw-semibold mb-3">
                                            <?php echo $days_present > 0 ? $days_present : '-'; ?>
                                        </h4>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-clock fs-6"></i>
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
        </div>

        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-start">
                                <div class="col-8">
                                    <h5 class="card-title mb-9 fw-semibold">Total Hours Worked This Week</h5>
                                    <h4 class="fw-semibold mb-3">
                                        <?php echo $total_hours_week > 0 ? $total_hours_week . ' Hours' : '-'; ?>
                                    </h4>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-clock fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
</div>

<?php
include_once '_partials/_footer.php';
?>
