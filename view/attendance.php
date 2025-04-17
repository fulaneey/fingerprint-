<?php
include_once '_partials/_header.php';
?>

<div class="container-fluid">
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Your Attendance</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Id</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Attendance Date</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Sign-in Time</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Sign-out Time</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Total Hours Spent</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '../backend/php/connection.php';

                        // Assuming the user's ID is stored in session
                        $user_id = $_SESSION['user_id'];

                        // Fetch all attendance records for the logged-in user, grouped by date
                        $sql = "SELECT attendance_date, GROUP_CONCAT(time ORDER BY time SEPARATOR ',') AS times 
                                FROM attendance 
                                WHERE user_id = ? 
                                GROUP BY attendance_date 
                                ORDER BY attendance_date DESC";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $counter = 1;
                            while ($row = $result->fetch_assoc()) {
                                $attendance_date = $row['attendance_date'];
                                $times = explode(',', $row['times']);

                                // Initialize variables to store sign-in and sign-out pairs
                                $sign_in_times = [];
                                $sign_out_times = [];
                                $total_hours = 0;

                                // Loop through the times and pair sign-in and sign-out
                                for ($i = 0; $i < count($times); $i++) {
                                    if ($i % 2 == 0) {
                                        // Even index: Sign-in
                                        $sign_in_times[] = $times[$i];
                                    } else {
                                        // Odd index: Sign-out
                                        $sign_out_times[] = $times[$i];

                                        // Calculate time difference for this pair
                                        $sign_in_time = strtotime($times[$i - 1]);
                                        $sign_out_time = strtotime($times[$i]);

                                        if ($sign_out_time < $sign_in_time) {
                                            $sign_out_time += 86400; // Adjust for next day sign-out
                                        }

                                        $time_diff = $sign_out_time - $sign_in_time;
                                        $total_hours += $time_diff;
                                    }
                                }

                                // Format total hours
                                $hours = floor($total_hours / 3600);
                                $minutes = floor(($total_hours % 3600) / 60);
                                $total_time = sprintf('%02d:%02d', $hours, $minutes);

                                // Determine badge color
                                $badge_color = $hours < 4 ? "bg-danger" :
                                    ($hours < 6 ? "bg-warning" :
                                    ($hours < 8 ? "bg-success" : "bg-primary"));

                                // Display the row
                                echo "<tr>";
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>{$counter}</h6></td>";
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>" . date('d-m-Y', strtotime($attendance_date)) . "</h6></td>";

                                // Display sign-in times
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>";
                                foreach ($sign_in_times as $time) {
                                    echo date('h:i A', strtotime($time)) . "<br>";
                                }
                                echo "</h6></td>";

                                // Display sign-out times
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>";
                                foreach ($sign_out_times as $time) {
                                    echo date('h:i A', strtotime($time)) . "<br>";
                                }
                                echo "</h6></td>";

                                // Display total hours
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>
                                        <span class='badge $badge_color rounded-3 fw-semibold'>$total_time Hours</span>
                                      </h6></td>";

                                echo "</tr>";
                                $counter++;
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No attendance records found.</td></tr>";
                        }

                        $stmt->close();
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include_once '_partials/_footer.php';
?>