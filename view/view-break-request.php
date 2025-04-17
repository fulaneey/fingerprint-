<?php
include_once '_partials/_header.php';
?>

<div class="container-fluid">
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Your Break Requests</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Id</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Leave Time</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Return Time</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Reason</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Status</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Action</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '../backend/php/connection.php';

                        $user_id = $_SESSION['user_id'];

                        $sql = "SELECT id, leave_time, return_time, reason, admin_reason, created_at, status FROM leave_requests WHERE user_id = ? ORDER BY created_at DESC";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $counter = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>" . $counter . "</h6></td>";
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>" . date('h:i A', strtotime($row['leave_time'])) . "</h6></td>";
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>" . date('h:i A', strtotime($row['return_time'])) . "</h6></td>";
                                echo "<td class='border-bottom-0'><p class='mb-0 fw-normal'>" . htmlspecialchars($row['reason']) . "</p></td>";
                                echo "<td class='border-bottom-0'><span class='badge bg-" . ($row['status'] == 'approved' ? 'success' : ($row['status'] == 'pending' ? 'warning' : 'danger')) . " rounded-3 fw-semibold'>" . ucfirst($row['status']) . "</span></td>";
                                echo "<td class='border-bottom-0'>";

                                if ($row['status'] == 'pending') {
                                    echo "<a href='delete_request.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this request?\")'>Delete</a>";
                                } elseif ($row['status'] == 'approved') {
                                    echo "<a href='extend-break.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Extend</a>";
                                } elseif ($row['status'] == 'denied') {
                                    echo "<button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#denialReasonModal' data-request-id='" . $row['id'] . "'>See Reason</button>";
                                }

                                echo "</td>";
                                echo "</tr>";
                                $counter++;
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No break requests found.</td></tr>";
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

<!-- Denial Reason Modal -->
<div class="modal fade" id="denialReasonModal" tabindex="-1" aria-labelledby="denialReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="denialReasonModalLabel">Denial Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="denialReasonText"></p> <!-- Placeholder for the reason -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle the modal trigger
    var denialReasonModal = document.getElementById('denialReasonModal');
    denialReasonModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var requestId = button.getAttribute('data-request-id'); // Extract request ID

        // Fetch the denial reason using AJAX
        fetch('get_denial_reason.php?id=' + requestId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Populate the modal with the reason
                    document.getElementById('denialReasonText').innerText = data.reason;
                } else {
                    // Handle error
                    document.getElementById('denialReasonText').innerText = 'Reason not found.';
                }
            })
            .catch(error => {
                console.error('Error fetching denial reason:', error);
                document.getElementById('denialReasonText').innerText = 'Error fetching reason.';
            });
    });

    // Reset the modal when hidden
    denialReasonModal.addEventListener('hidden.bs.modal', function () {
        document.getElementById('denialReasonText').innerText = ''; // Clear the reason
    });
});
</script>

<?php
include_once '_partials/_footer.php';
?>