function inputFilled(inputs) {
    for (let input of inputs) {
        if (input.tagName === "IMG" && input.src == "") {
            return false;
        }

        if (input.value == "") {
            return false;
        }
    }
    return true;
}

const COD = document.querySelector("#cash-on-delivery");
const atmOptions = document.getElementById("atm-options");
const atmPayment = document.querySelector("#atm-payment");

atmPayment.addEventListener("click", togglePaymentOptions);
function togglePaymentOptions() {
    atmOptions.style.display = "block";
}

COD.addEventListener("click", toggleCOD);
function toggleCOD() {
    atmOptions.style.display = "none";
}