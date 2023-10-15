// Personal Account Details
const editAccount = document.getElementById("editable-personal-account-info");
const regAccount = document.getElementById("personal-account-info");

const editAccountButton = document.getElementById("edit-account");
const editAccountButtonBack = document.getElementById("edit-account-back");

editAccountButton.addEventListener("click", function () {
    editAccount.classList.remove("hidden");
    regAccount.classList.add("hidden");
});

editAccountButtonBack.addEventListener("click", function() {
    editAccount.classList.add("hidden");
    regAccount.classList.remove("hidden");
});

// Learner Payment
const editLearnerPayment = document.getElementById("editable-card-payment-details");
const regLearnerPayment = document.getElementById("card-payment-details");

const editLearnerPaymentButton = document.getElementById("edit-learner-payment");
const editLearnerPaymentButtonBack = document.getElementById("edit-learner-payment-back")

editLearnerPaymentButton.addEventListener("click", function () {
    editLearnerPayment.classList.remove("hidden");
    regLearnerPayment.classList.add("hidden");
});

editLearnerPaymentButtonBack.addEventListener("click", function () {
    editLearnerPayment.classList.add("hidden");
    regLearnerPayment.classList.remove("hidden");
});

// Instructor Payment
const editInstructorPayment = document.getElementById("editable-instructor-payment-info");
const regInstructorPayment = document.getElementById("instructor-payment-info");

const editInstructorPaymentButton = document.getElementById("edit-instructor-payment");
const editInstructorPaymentButtonBack = document.getElementById("edit-instructor-payment-back")

editInstructorPaymentButton.addEventListener("click", function () {
    editInstructorPayment.classList.remove("hidden");
    regInstructorPayment.classList.add("hidden");
});

editInstructorPaymentButtonBack.addEventListener("click", function () {
    editInstructorPayment.classList.add("hidden");
    regInstructorPayment.classList.remove("hidden");
});
