function Switch(x,y){
    switch (x) {

        case 'tc':
            // $("#admin-content").load("home.php");
            break;
        case 'tk':
            $("#admin-content").load("/webbantruyen/view/admin/account.php", function () {
                setTimeout(function () {
                    CheckRole(y);
                }, 50); 
            });
            break;
        case 'nv':
            $("#admin-content").load("/webbantruyen/view/admin/employee.php", function () {
                setTimeout(function () {
                    CheckRole(y);
                }, 50); 
            });
            break;
        case 'kh':
            $("#admin-content").load("/webbantruyen/view/admin/customer.php", function () {
                 setTimeout(function () {
                    CheckRole(y);
                }, 50)});
            break;
        case 'sp':
            $("#admin-content").load("/webbantruyen/view/admin/product.php", function () {
                 setTimeout(function () {
                    CheckRole(y);
                }, 50); 
            });
        
            break;
        case 'km':
            $("#admin-content").load("/webbantruyen/view/admin/promotion.php");
            break;
        case 'tl':
            // $("#admin-content").load("/webbantruyen/view/admin/genres.php");
            break;
        case 'hdb':
            // $("#admin-content").load("/webbantruyen/view/admin/sales.php");
            break;
        case 'hdn':
            $("#admin-content").load("/webbantruyen/view/admin/import.php" , function () { 
                setTimeout(function () {
                    CheckRole(y);
                }, 50);});
            break;
        case 'ncc':
            // $("#admin-content").load("/webbantruyen/view/admin/supplier.php");
            break;
        case 'pq':
            $("#admin-content").load("/webbantruyen/view/admin/permissions.php", function () {
                permissions()
                 setTimeout(function () {
                    CheckRole(y);
                }, 50); ;
            });
            break;
        case 'role':
            $("#admin-content").load("/webbantruyen/view/admin/Role.php", function () {
                setTimeout(function () {
                    CheckRole(y);
                }, 50); 
            });
            break;
        case 'tk':
            // $("#admin-content").load("/webbantruyen/view/admin/statistic.php");
            break;
        default:
            break;
    }

}