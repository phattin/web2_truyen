function Switch(x){
    
    
    switch (x) {

        case 'tc':
            // $("#admin-content").load("home.php");
            break;
        case 'nv':
            $("#admin-content").load("/webbantruyen/view/admin/employee.php");
            break;
        case 'kh':
            $("#admin-content").load("/webbantruyen/view/admin/guest.php");
            break;
        case 'sp':
            $("#admin-content").load("/webbantruyen/view/admin/product.php");
            break;
        case 'km':
            // $("#admin-content").load("/webbantruyen/view/admin/promotion.php");
            break;
        case 'tl':
            // $("#admin-content").load("/webbantruyen/view/admin/genres.php");
            break;
        case 'hdb':
            // $("#admin-content").load("/webbantruyen/view/admin/sales.php");
            break;
        case 'hdn':
            $("#admin-content").load("/webbantruyen/view/admin/import.php");
            break;
        case 'ncc':
            // $("#admin-content").load("/webbantruyen/view/admin/supplier.php");
            break;
        case 'pq':
            $("#admin-content").load("/webbantruyen/view/admin/permissions.php", function () {
                permissions();
            });
            break;
        case 'role':
            $("#admin-content").load("/webbantruyen/view/admin/Role.php");
            break;
        case 'tk':
            // $("#admin-content").load("/webbantruyen/view/admin/statistic.php");
            break;
        default:
            break;
    }

}