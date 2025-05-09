function Switch(x){
    
    
    switch (x) {

        case 'tc':
            // $("#admin-content").load("home.php");
            break;
        case 'nv':
            $("#admin-content").load("employee.php");
            break;
        case 'kh':
            $("#admin-content").load("guest.php");
            break;
        case 'sp':
            $("#admin-content").load("product.php");
            break;
        case 'km':
            // $("#admin-content").load("promotion.php");
            break;
        case 'tl':
            // $("#admin-content").load("genres.php");
            break;
        case 'hdb':
            // $("#admin-content").load("sales.php");
            break;
        case 'hdn':
            $("#admin-content").load("import.php");
            break;
        case 'ncc':
            // $("#admin-content").load("supplier.php");
            break;
        case 'pq':
            $("#admin-content").load("permissions.php", function () {
                permissions();
            });
            break;
        case 'role':
            $("#admin-content").load("Role.php");
            break;
        case 'tk':
            // $("#admin-content").load("statistic.php");
            break;
        default:
            break;
    }

}