<?php
include_once '_partials/_admin_header.php';
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
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">User Email</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Leave Time</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Return Time</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Reason</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Status</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Request Time</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Action</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '../backend/php/connection.php';

                        $sql = "SELECT lr.id, u.email, lr.leave_time, lr.return_time, lr.reason, lr.status, lr.request_time, lr.created_at
                                FROM leave_requests lr
                                JOIN users u ON lr.user_id = u.id
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
                                echo "<td class='border-bottom-0'><span class='badge bg-" . ($row['status'] == 'approved' ? 'success' : ($row['status'] == 'pending' ? 'warning' : 'danger')) . " rounded-3 fw-semibold'>" . ucfirst($row['status']) . "</span></td>";
                                echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>" . date('Y-m-d H:i:s', strtotime($row['created_at'])) . "</h6></td>";
                                echo "<td class='border-bottom-0'>";

                                if ($row['status'] == 'pending') {
                                    echo "<form method='POST' action='admin-update-leave-status.php' class='d-inline'>";
                                    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                                    echo "<button type='submit' name='action' value='approved' class='btn btn-success btn-sm'>Approve</button>";
                                    echo "<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#denyReasonModal' data-request-id='" . $row['id'] . "'>Deny</button>";
                                    echo "</form>";
                                } elseif ($row['status'] == 'approved') {
                                    echo "<span class='text-success'>Approved</span>";
                                } elseif ($row['status'] == 'denied') {
                                    echo "<span class='text-danger'>Denied</span>";
                                }

                                echo "</td>";
                                echo "</tr>";
                                $counter++;
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No leave requests found.</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Deny Reason Modal -->
<div class="modal fade" id="denyReasonModal" tabindex="-1" aria-labelledby="denyReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="denyReasonModalLabel">Provide Denial Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="denyForm" method="POST" action="admin-update-leave-status.php">
                    <input type="hidden" name="id" id="denyRequestId">
                    <input type="hidden" name="action" value="denied">
                    <div class="mb-3">
                        <label for="denyReason" class="form-label">Reason for Denial</label>
                        <textarea class="form-control" id="denyReason" name="admin_reason" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var denyReasonModal = document.getElementById('denyReasonModal');
    denyReasonModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var requestId = button.getAttribute('data-request-id');
        var modalInput = denyReasonModal.querySelector('#denyRequestId');
        modalInput.value = requestId;
    });

    denyReasonModal.addEventListener('hidden.bs.modal', function () {
        var form = denyReasonModal.querySelector('#denyForm');
        form.reset();
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Check if the URL contains 'status=success'
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status') && urlParams.get('status') === 'success') {
        // Show SweetAlert notification
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'The leave request status was updated successfully.',
            confirmButtonText: 'OK'
        }).then(() => {
            // Remove the 'status' parameter from the URL
            const newUrl = window.location.href.split('?')[0];
            window.history.replaceState({}, document.title, newUrl);
        });
    }
});
</script>

<?php
include_once '_partials/_footer.php';
?>