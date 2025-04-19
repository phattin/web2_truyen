function Switch($x){
    
    
    switch ($x) {
        case 2:
            $("#content").load("employee.php");
            break;
        case 3:
            $("#content").load("guest.php");
            break;
        case 4:
            $("#content").load("product.php");
            break;
        case 5:
            $("#content").load("permissions.php", function () {
                permissions();
            });
            break;
        case 6:
            $("#content").load("Role.php");
            break;
        default:
    }

}