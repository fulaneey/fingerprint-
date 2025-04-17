<?php
// Include the header and database connection
include_once '_partials/_header.php';
require_once '../backend/php/connection.php';

// Get the request ID from the URL
$request_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the leave request details
if ($request_id > 0) {
    $sql = "SELECT id, leave_time, return_time, reason, extended_time, reason_for_extension, status FROM leave_requests WHERE id = ? AND status = 'approved'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>Leave request not found or not approved.</p>";
        exit;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "<p>Invalid request ID.</p>";
    exit;
}

// Handle form submission for extension
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reason_for_extension = $_POST['reason_for_extension'];
    $extended_time = $_POST['extended_time'];

    // Update the leave request with the extension details
    $update_sql = "UPDATE leave_requests SET reason_for_extension = ?, extended_time = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $reason_for_extension, $extended_time, $request_id);

    if ($update_stmt->execute()) {
        // Display the success alert using SweetAlert2
        echo "
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Success!',
                text: 'Your request has been submitted successfully.',
                icon: 'success',
                confirmButtonText: 'OK',
            }).then(() => {
                window.location.href = 'view-break-request.php';
            });
        });
    </script>
    ";
    }


    // Close the update statement
    $update_stmt->close();
}

// Close the database connection
$conn->close();
?>


<div class="container-fluid">
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Extend Your Break</h5>
            <form method="POST">
                <div class="mb-3">
                    <label for="leave_time" class="form-label">Leave Time</label>
                    <input type="text" class="form-control" id="leave_time"
                        value="<?= date('h:i A', strtotime($row['leave_time'])) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="return_time" class="form-label">Return Time</label>
                    <input type="text" class="form-control" id="return_time"
                        value="<?= date('h:i A', strtotime($row['return_time'])) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea class="form-control" id="reason"
                        readonly><?= htmlspecialchars($row['reason']) ?></textarea>
                </div>
               <div class="mb-3">
    <label for="reason_for_extension" class="form-label">Reason for Extension</label>
    <textarea name="reason_for_extension" id="reason_for_extension" class="form-control" required><?= isset($row['reason_for_extension']) ? htmlspecialchars(trim($row['reason_for_extension'])) : '' ?></textarea>
            </div>

                
                <div class="mb-3">
                    <label for="extended_time" class="form-label">Extended Time</label>
                    <input type="time" name="extended_time" id="extended_time" class="form-control"
                        value="<?= isset($row['extended_time']) ? date('H:i', strtotime($row['extended_time'])) : '' ?>" required>
                </div>


                <button type="submit" class="btn btn-primary">Submit Extension</button>
            </form>
        </div>
    </div>
</div>

<?php
include_once '_partials/_footer.php';
?>