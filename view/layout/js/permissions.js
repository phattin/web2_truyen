function permissions() {
    $.ajax({
        type: "POST",
        url: "../admin/rolename.php",
        dataType: "json",
        success: function (response) {
            console.log(response);
            for (let i = 0; i < response.length; i++) {
                let elementId =response[i].UserName;
                let element = document.getElementById(elementId);
                
                if (element) {
                    element.value = response[i].RoleName;
                    element.querySelector(`option[value="${response[i].RoleName}"]`)?.setAttribute("selected", true);
                } else {
                    console.warn("Không tìm thấy phần tử với id: " + elementId);
                    break;
                }
            }
        }
    });
};
