const inputPayment = document.getElementById("input-payment");
const filePayment = document.getElementById("file-payment");

inputPayment.classList.add("hidden");

document.getElementById("on-file").addEventListener("click", function() {
    filePayment.classList.remove("hidden");
    inputPayment.classList.add("hidden");
});

document.getElementById("input").addEventListener("click", function() {
    filePayment.classList.add("hidden");
    inputPayment.classList.remove("hidden");
});