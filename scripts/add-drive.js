const submitButton = document.getElementById("add-drive");

const option = document.getElementById("permit-number");
option.addEventListener("input", checkForLicence);

function checkForLicence(e) {
    if (option.value == "none") {
        option.setCustomValidity("Please select a learner driver");
        e.preventDefault();
    } else {
        option.setCustomValidity("");
    }
}

submitButton.addEventListener("submit", checkForLicence);

const startTime = document.getElementById("start-time");
const endTime = document.getElementById("end-time");

endTime.addEventListener("input", compareDates);
endTime.addEventListener("input", compareDates);

function compareDates(e) {
    let start = startTime.value;
    let end = endTime.value;
    if (start >= end) {
        endTime.setCustomValidity("End Time is before Start Time");
        e.preventDefault();
    } else {
        endTime.setCustomValidity("");
    }
}

submitButton.addEventListener("submit", compareDates);
