const editAccount = document.getElementById("editable-account-info");
const immutableAccount = document.getElementById("immutable-account-info");

const editButton = document.getElementById("edit-account");

editButton.addEventListener("click", function () {
    editAccount.classList.remove("hidden");
    immutableAccount.classList.add("hidden");
});
