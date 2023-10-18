const view = document.getElementById("view");
const edit = document.getElementById("edit");

const editButton = document.getElementById("about-me-edit-button");

// Hides the view and shows the edit
editButton.addEventListener("click", function() {
    view.classList.add("hidden");
    edit.classList.remove("hidden");
});

const editTextarea = document.getElementById("about-me-textarea");
const count = document.getElementById("count");
var countNum = 0;

const aboutMeLength = 512;

// Calculates the length of the textarea and changes the count label
editTextarea.addEventListener("keyup", function() {
    countNum = this.value.length;
    let charsLeft = 512 - countNum;
    if (charsLeft < 0) {
        count.classList.add("count-bad");
    } else if (count.classList.contains("count-bad")) {
        count.classList.remove("count-bad");
    }
    count.innerHTML = charsLeft + " characters left!";
});

const form = document.getElementById("about-me-form");
form.addEventListener("submit", compareChars);

// compares the length and prevents submission if too many chars
function compareChars(e) {
    if (aboutMeLength - countNum < 0) {
        editTextarea.setCustomValidity("Too many characters!");
        e.preventDefault();
    } else {
        editTextarea.setCustomValidity("");
    }
}

function init() {
    countNum = editTextarea.innerHTML.length;
    count.innerHTML = 512 - countNum + " characters left!";
}

init();