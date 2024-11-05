javascript.js
// JavaScript code in frontend
// Example: Sending a login request to backend
const userData = {
    username: 'example_username',
    password: 'example_password'
};

fetch('login.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(userData)
})
.then(response => response.json())
.then(data => {
    // Handle response data (e.g., display user data, redirect to dashboard, show error message)
})
.catch(error => {
    // Handle error (e.g., show error message)
});
