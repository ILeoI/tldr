const option = document.getElementById("permit-number");

document.getElementById("add-drive").addEventListener("submit", checkForLicense);
option.addEventListener("input", checkForLicense);

function checkForLicense(e) {
    if (option.value == "none") {
        option.setCustomValidity("Please select a license number");
        e.preventDefault();
    } else {
        option.setCustomValidity("");
    }
}