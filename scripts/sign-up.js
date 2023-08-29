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