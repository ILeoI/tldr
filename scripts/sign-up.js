// Show or hide passwords
function togglePassword() {
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm-password");

    if (password.type === "text") {
        password.type = "password";
        confirmPassword.type = "password";
    } else {
        password.type = "text";
        confirmPassword.type = "text";
    }
}

// Check if password and confirm password don't match
function validatePasswords() {
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm-password");

    if (password.value != confirmPassword.value) {
        confirmPassword.setCustomValidity("Passwords do not match");
    } else {
        confirmPassword.setCustomValidity("");
    }

}

// Init Function, stuff to be run on launch
function init() {
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm-password");
    password.onchange = validatePasswords;
    confirmPassword.onkeyup = validatePasswords;
}

init();