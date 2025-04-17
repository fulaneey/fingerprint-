<?php
include_once '_partials/_header.php';

?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
        <?php
include_once('../backend/php/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit; // Exit if user is not logged in
}

// Get the current logged-in user's ID
$userId = $_SESSION['user_id'];

// Fetch existing user profile data
$stmt = $conn->prepare("SELECT date_of_birth, phone_number, rank_level, department, staff_id, address_staff, next_of_kin_name, next_of_kin_phone FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<form method="POST" action="../backend/php/profile.php">
    <div class="mb-3">
        <label for="dob" class="form-label">Date of Birth</label>
        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo isset($profile['date_of_birth']) ? $profile['date_of_birth'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($profile['phone_number']) ? $profile['phone_number'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="rank" class="form-label">Rank/Level</label>
        <select class="form-control" id="rank" name="rank" required>
            <option value="" disabled>Select your level</option>
            <?php
            for ($i = 4; $i <= 12; $i++) {
                $selected = (isset($profile['rank_level']) && $profile['rank_level'] == $i) ? 'selected' : '';
                echo "<option value='$i' $selected>Level $i</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="department" class="form-label">Department</label>
        <select class="form-control" id="department" name="department" required>
            <option value="" disabled>Select Department</option>
            <?php
            $departments = ['Transmission', 'Distribution', 'Customer Service', 'Maintenance'];
            foreach ($departments as $dept) {
                $selected = (isset($profile['department']) && $profile['department'] == $dept) ? 'selected' : '';
                echo "<option value='$dept' $selected>$dept</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
    <label for="staffID" class="form-label">Staff ID</label>
    <input type="text" class="form-control" id="staffID" name="staffID" 
           value="<?php echo isset($profile['staff_id']) ? $profile['staff_id'] : 'KEDC-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); ?>" 
           readonly>
</div>

    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address_staff" value="<?php echo isset($profile['address_staff']) ? $profile['address_staff'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="nextOfKinName" class="form-label">Next of Kin Name</label>
        <input type="text" class="form-control" id="nextOfKinName" name="nextOfKinName" value="<?php echo isset($profile['next_of_kin_name']) ? $profile['next_of_kin_name'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="nextOfKinPhone" class="form-label">Next of Kin Phone Number</label>
        <input type="tel" class="form-control" id="nextOfKinPhone" name="nextOfKinPhone" value="<?php echo isset($profile['next_of_kin_phone']) ? $profile['next_of_kin_phone'] : ''; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>



        </div>
    </div>
</div>
<?php
include_once '_partials/_footer.php';

?>