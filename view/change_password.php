<?php
include_once '_partials/_header.php';

?>

<!-- users password:
22
1111
2222 -->

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="../backend/php/change_password.php">
                <div class="mb-3">
                    <label for="oldPassword" class="form-label">Old Password</label>
                    <input type="password" class="form-control" id="oldPassword" name="old_password" required>
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="newPassword" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirmNewPassword" name="confirm_new_password" required>
                </div>
                <div id="passwordHelp" class="form-text">Make sure your passwords match.</div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </form>
        </div>
    </div>

</div>
<?php
include_once '_partials/_footer.php';

?>