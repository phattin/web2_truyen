<?php
    // Kiểm tra session
if (session_status() === PHP_SESSION_NONE)
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/webbantruyen/model/productDB.php';

    $limitHome = 9;
    $pageHome = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offsetHome = ($pageHome - 1) * $limitHome;


    // Lấy toàn bộ sản phẩm
    $productsHome = productDB::getAllProduct();

    // Gửi mảng vào để tìm kiếm
    // echo "<script>const productsHome = " . json_encode($productsHome) . ";</script>";

    // Lấy sản phẩm đã tìm kiếm
    // Kiểm tra nếu có dữ liệu gửi đến
    // if (isset($_POST["productsHomeFound"]))
    //     $productsHomeFound = json_decode($_POST["productsHomeFound"], true);
    // else 
    //     $productsHomeFound = $productsHome;

    // Lấy sản phẩm cho trang hiện tại
    $resultHome = array_slice($productsHome, $offsetHome, $limitHome);

    // Tổng số trang
    $total_productsHome = count($productsHome);
    $total_pagesHome = ceil($total_productsHome / $limitHome);

    // Trả về HTML thay vì tải lại trang
    ob_start();
?>
<div class="product-grid">
    <?php
    foreach ($resultHome as $productHome) {
        // Lấy thông tin sản phẩm và xử lý
        $productID = $productHome['ProductID'];
        $productImg = $productHome['ProductImg'];
        $productName = $productHome['ProductName']; 
        $importPrice = $productHome['ImportPrice'];
        $ros = $productHome['ROS'];
        
        // Tính toán giá bán
        $price = round($importPrice * ( 1 + $ros ));
        $formattedPrice = number_format($price, 0, ',', '.') . ' VNĐ';
    ?>
        <div class="product-item">
            <a href="index.php?page=product_detail&id=<?= $productID ?>">
                <img src="view/layout/images/<?= $productImg ?>" alt="<?= $productName ?>">
            </a>
            <h3><?= $productName ?></h3>
            <p class="price"><?= $formattedPrice ?></p>

            <!-- Form gửi sản phẩm vào giỏ hàng -->
            <form action="view/layout/page/cart.php" method="POST">
                <input type="hidden" name="id" value="<?= $productID ?>">
                <input type="hidden" name="name" value="<?= $productName ?>">
                <input type="hidden" name="price" value="<?= $formattedPrice ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-add-to-cart">Thêm vào giỏ hàng</button>
            </form>
        </div>
    <?php
    }
    ?>
</div>

<!-- Phân trang -->
<div class="pagination">
    <ul>
        <?php
        for ($i = 1; $i <= $total_pagesHome; $i++) {
            // Tạo các nút phân trang với dữ liệu về số trang
            if($i!=1)
                echo '<li class="btn-pagination" data-page="home" data-page_number="' . $i . '">' . $i . '</li>';
            else
                echo '<li class="btn-pagination active" data-page="home" data-page_number="' . $i . '">' . $i . '</li>';
        }
        echo '<li class="btn-pagination" data-page="${page}" data-page_number="2">&gt;</li>'
        ?>
    </ul>
</div>
<script>
    
    const cartIcon = document.getElementById("cart-icon");
    const isLoggedIn = !!document.querySelector(".user-menu"); // Kiểm tra user đăng nhập
    function addToCart(button) {
                if (!isLoggedIn) {
                    alert("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!");
                    window.location.href = "index.php?page=login";
                    return;
                }

                const productItem = button.closest(".product-item");
                const form = button.closest("form");
                const formData = new FormData(form);

                fetch("view/layout/page/cart.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cartCount = data.cart_count;
                        updateCartCount();

                        cartIcon.classList.add("shake");
                        setTimeout(() => {
                            cartIcon.classList.remove("shake");
                        }, 500);

                        showFlyEffect(productItem);
                    } else {
                        alert(data.message || "Có lỗi xảy ra khi thêm vào giỏ hàng.");
                    }
                })
                .catch(error => {
                    console.error("Lỗi:", error);
                    alert("Không thể thêm sản phẩm vào giỏ hàng. Vui lòng thử lại.");
                });
    }
    // Hàm cập nhật số lượng sản phẩm trên icon giỏ hàng
    function updateCartCount() {
        if (!cartIcon) return; // Nếu không tìm thấy phần tử, thoát luôn tránh lỗi

        let cartBadge = cartIcon.querySelector(".cart-count");
        if (!cartBadge) {
            cartBadge = document.createElement("span");
            cartBadge.classList.add("cart-count");
            cartIcon.appendChild(cartBadge);
        }
        cartBadge.textContent = cartCount;
    }

    // Hiệu ứng hình ảnh bay vào giỏ hàng
    function showFlyEffect(productItem) {
        const productImage = productItem.querySelector("img");
        if (productImage && cartIcon) {
            const flyImage = productImage.cloneNode(true);
            const rect = productImage.getBoundingClientRect();

            flyImage.style.position = "fixed";
            flyImage.style.top = `${rect.top}px`;
            flyImage.style.left = `${rect.left}px`;
            flyImage.style.width = `${rect.width}px`;
            flyImage.style.height = `${rect.height}px`;
            flyImage.style.transition = "all 1s ease-in-out";
            flyImage.style.zIndex = "9999";

            document.body.appendChild(flyImage);

            const cartRect = cartIcon.getBoundingClientRect();

            setTimeout(() => {
                flyImage.style.top = `${cartRect.top}px`;
                flyImage.style.left = `${cartRect.left}px`;
                flyImage.style.width = "30px";
                flyImage.style.height = "30px";
                flyImage.style.opacity = "0.5";
            }, 100);

            flyImage.addEventListener("transitionend", () => {
                flyImage.remove();
            });
        }
    }
</script>
<?php
$response = ob_get_clean();
echo $response;
?>