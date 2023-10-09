// Personal Account Details
const editAccount = document.getElementById("editable-personal-account-info");
const regAccount = document.getElementById("personal-account-info");

const editAccountButton = document.getElementById("edit-account");

editAccountButton.addEventListener("click", function () {
    editAccount.classList.remove("hidden");
    regAccount.classList.add("hidden");
});

// Learner Payment
const editLearnerPayment = document.getElementById("editable-card-payment-details");
const regLearnerPayment = document.getElementById("card-payment-details");

const editLearnerPaymentButton = document.getElementById("edit-learner-payment");

editLearnerPaymentButton.addEventListener("click", function () {
    editLearnerPayment.classList.remove("hidden");
    regLearnerPayment.classList.add("hidden");
});

// Instructor Payment
const editInstructorPayment = document.getElementById("editable-instructor-payment-info");
const regInstructorPayment = document.getElementById("instructor-payment-info");

const editInstructorPaymentButton = document.getElementById("edit-instructor-payment");

editInstructorPaymentButton.addEventListener("click", function () {
    editInstructorPayment.classList.remove("hidden");
    regInstructorPayment.classList.add("hidden");
});
