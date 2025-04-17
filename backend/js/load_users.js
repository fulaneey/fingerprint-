

    document.addEventListener('DOMContentLoaded', function () {
        // fetch('./backend/php/fetch_users.php')
        fetch('/FingerPrint/backend/php/fetch_users.php')

            .then(response => response.json())
            .then(data => {
                let userSelect = document.getElementById('userID');
                data.forEach(user => {
                    let option = document.createElement('option');
                    option.value = user.id;
                    option.text = user.fullname;
                    userSelect.add(option);
                });
            })
            .catch(error => console.error('Error fetching user data:', error));
    });