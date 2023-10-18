const view = document.getElementById("view");
const edit = document.getElementById("edit");

const editButton = document.getElementById("about-me-edit-button");

editButton.addEventListener("click", function() {
    view.classList.add("hidden");
    edit.classList.remove("hidden");
});

const editTextarea = document.getElementById("about-me-textarea");
const count = document.getElementById("count");
var countNum = 0;

const aboutMeLength = 512;

editTextarea.addEventListener("keyup", function() {
    countNum = this.value.length;
    let charsLeft = 512 - countNum;
    if (charsLeft < 0) {
        count.classList.add("count-bad");
    } else if (count.classList.contains("count-bad")) {
        count.classList.remove("count-bad");
    }
    console.log(charsLeft);
    count.innerHTML = charsLeft + " characters left!";
});

const submitButton = document.getElementById("about-me-submit-button");

submitButton.addEventListener("submit", function(e) {
    if (countNum > aboutMeLength) {
        editTextarea.setCustomValidity("Too many characters!");
        e.preventDefault();
    } else {
        editTextarea.setCustomValidity("");
    }
});

function init() {
    countNum = editTextarea.innerHTML.length;
    count.innerHTML = 512 - countNum + " characters left!";
}

init();