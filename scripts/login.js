// Show or hide passwords
function togglePassword() {
    const password = document.getElementById("password");
    
    if (password.type === "text") {
        password.type = "password";
    } else {
        password.type = "text";
    }
}
