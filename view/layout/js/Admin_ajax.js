function Swicth($x){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("content").innerHTML = this.responseText;
    }
    switch ($x) {
        case 2:
            xhttp.open("GET", "employee.php", true);
            xhttp.send();
            break;
        case 3:
            xhttp.open("GET", "guest.php", true);
            xhttp.send();
            break;
        case 4:
            xhttp.open("GET", "product.php", true);
            xhttp.send();
            break;
        default:
            xhttp.open("GET", "admin_home.php", true);
            xhttp.send();
    }
}