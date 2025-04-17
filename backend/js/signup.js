
function registerUser() {
    // Collect form data
    const fullName = document.getElementById('fullName').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    // Basic validation (optional, for better user experience)
    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return;
    }

    // Create FormData object to send data
    const formData = new FormData();
    formData.append('fullName', fullName);
    formData.append('email', email);
    formData.append('password', password);

    // Send data to the PHP script using fetch API
    fetch('../backend/php/signup.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Display success or error message
        if (data.includes("success")) {
            window.location.href = "../view/login.php"; // Redirect to login page on success
        }
    })
    .catch(error => console.error('Error:', error));
}
