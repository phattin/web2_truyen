function switchModule($x){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("content").innerHTML = this.responseText;
    }
    switch ($x) {
        case 2:
            xhttp.open("GET", "view/admin/employee.php", true);
            xhttp.send();
            break;
        case 3:
            xhttp.open("GET", "view/admin/guest.php", true);
            xhttp.send();
            break;
        case 4:
            xhttp.open("GET", "view/admin/product.php", true);
            xhttp.send();
            break;
        default:
            xhttp.open("GET", "view/admin/admin_home.php", true);
            xhttp.send();
    }
}