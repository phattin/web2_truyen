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
function getAllSelectIDsInTable(tableID) {
    const table = document.getElementById(tableID);
    const selects = table.querySelectorAll("select");
    const ids = [];

    selects.forEach(select => {
        ids.push(select.id);
    });

    console.log("Tất cả ID của select:", ids);
    return ids;
}

function LuuRole() {
    let ids= [];
    ids = getAllSelectIDsInTable("table_role");
    let permissions = [];
    ids.forEach(id => {
        const select = document.getElementById(id);
        const selectedValue = select.options[select.selectedIndex].value;
        permissions.push({ id, selectedValue });
    });
    console.log(permissions);
    $.ajax({
        type: "POST",
        data: { permissions: JSON.stringify(permissions) },
        url: "../admin/LuuRole.php",
        dataType: "json",
        success: function (respose) {
            console.log(respose);
        }
    });
}
