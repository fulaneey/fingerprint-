<?php
include_once '_partials/_header.php';

?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="../backend/php/submit_leave_request.php">
                <!-- <div class="mb-3">
                    <label for="leaveTime" class="form-label">Time to Leave</label>
                    <input type="time" class="form-control" id="leaveTime" name="leave_time" required min="08:00" max="16:00">
                </div>
                <div class="mb-3">
                    <label for="returnTime" class="form-label">Time to Return</label>
                    <input type="time" class="form-control" id="returnTime" name="return_time" required min="08:00" max="16:00">
                </div> -->
                <div class="mb-3">
    <label for="leaveTime" class="form-label">Time to Leave</label>
    <select class="form-control" id="leaveTime" name="leave_time" required>
        <option value="">Select Time</option>
    </select>
</div>

<div class="mb-3">
    <label for="returnTime" class="form-label">Time to Return</label>
    <select class="form-control" id="returnTime" name="return_time" required>
        <option value="">Select Time</option>
    </select>
</div>

<script>
    function populateTimeDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const startTime = 8 * 60;  // 08:00 AM in minutes
        const endTime = 17 * 60;   // 05:00 PM in minutes
        const interval = 30;       // 30 minutes per step

        for (let minutes = startTime; minutes <= endTime; minutes += interval) {
            const hours = Math.floor(minutes / 60);
            const mins = minutes % 60;
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const formattedHours = hours > 12 ? hours - 12 : hours; // Convert to 12-hour format
            const formattedMinutes = mins === 0 ? '00' : mins;
            const timeValue = `${String(hours).padStart(2, '0')}:${formattedMinutes}`;
            const timeDisplay = `${formattedHours}:${formattedMinutes} ${ampm}`;

            const option = new Option(timeDisplay, timeValue);
            dropdown.appendChild(option);
        }
    }

    // Populate both dropdowns
    populateTimeDropdown("leaveTime");
    populateTimeDropdown("returnTime");
</script>

                <div class="mb-3">
                    <label for="reason" class="form-label">Reason for Leaving</label>
                    <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Request</button>
            </form>
        </div>
    </div>
</div>





<?php
include_once '_partials/_footer.php';

?>