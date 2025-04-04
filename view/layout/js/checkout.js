

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
    
    const phoneInput = document.getElementById("phone-payment");
    const oldPhoneRadio = document.getElementById("oldPhone");
    const newPhoneRadio = document.getElementById("newPhone");
    console.log(oldPhoneRadio, newPhoneRadio);
    const customerPhone = "<?= $customer['Phone'] ?>"; // Lấy số điện thoại từ PHP


    function updatePhoneInput() {
        if (oldPhoneRadio.checked) {
            phoneInput.value = customerPhone;
            phoneInput.readOnly = true;
        } else {
            phoneInput.value = "";
            phoneInput.readOnly = false;
        }
    }

    // Gọi khi trang tải lần đầu
    updatePhoneInput();

    // Lắng nghe sự kiện thay đổi radio
    oldPhoneRadio.addEventListener("change", updatePhoneInput);
    newPhoneRadio.addEventListener("change", updatePhoneInput);