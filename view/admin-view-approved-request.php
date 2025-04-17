<?php
include_once '_partials/_admin_header.php';

?>

<div class="container-fluid">
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Approved Break Requests</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Id</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">User Email</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Leave Time</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Return Time</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Reason</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Status</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Request Time</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include database connection
                        require_once '../backend/php/connection.php';

                        // Query to fetch only approved leave requests
                        $sql = "SELECT lr.id, u.email, lr.leave_time, lr.return_time, lr.reason, lr.status, lr.request_time, lr.created_at
                                FROM leave_requests lr
                                JOIN users u ON lr.user_id = u.id
                                WHERE lr.status = 'approved'
                                ORDER BY lr.created_at DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $counter = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>" . $counter . "</h6></td>";
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>" . htmlspecialchars($row['email']) . "</h6></td>";
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>" . date('h:i A', strtotime($row['leave_time'])) . "</h6></td>";
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>" . date('h:i A', strtotime($row['return_time'])) . "</h6></td>";
                                echo "<td class='border-bottom-0'><p class='mb-0 fw-normal'>" . htmlspecialchars($row['reason']) . "</p></td>";
                                echo "<td class='border-bottom-0'><span class='badge bg-success rounded-3 fw-semibold'>" . ucfirst($row['status']) . "</span></td>";
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>" . date('Y-m-d H:i:s', strtotime($row['created_at'])) . "</h6></td>";
                                echo "</tr>";
                                $counter++;
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No approved break requests found.</td></tr>";
                        }

                        // Close connection
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