<main class="container">
    <div class="product-grid">
        <?php
            require 'model/productDB.php';

            $productDB = new productDB();
            
            // Lấy danh sách sản phẩm
            $products = $productDB->getAllProduct();
            foreach ($products as $product){
                echo '
                        <div class="product-item">
                            <img src="view/layout/images/jjk.jpg">
                            <h3>'.$product['ProductName'].'</h3>
                            <p class="price">'.$product['ROS'].' VND</p>
                            <button class="btn-add-to-cart">Thêm vào giỏ hàng</button>
                        </div>
                    ';
            }
                // echo '
                //         <div class="product-item">
                //             <img src="view/layout/images/jjk.jpg" alt="Product 1">
                //             <h3>Truyện 1</h3>
                //             <p class="price">100,000 VND</p>
                //             <button class="btn-add-to-cart">Thêm</button>
                //         </div>
                //         <div class="product-item">
                //             <img src="view/layout/images/aot.jpg" alt="Product 2">
                //             <h3>Truyện 2</h3>
                //             <p class="price">120,000 VND</p>
                //             <button class="btn-add-to-cart">Thêm</button>
                //         </div>
                //         <div class="product-item">
                //             <img src="view/layout/images/mha.jpg" alt="Product 3">
                //             <h3>Truyện 3</h3>
                //             <p class="price">150,000 VND</p>
                //             <button class="btn-add-to-cart">Thêm </button>
                //         </div><div class="product-item">
                //             <img src="view/layout/images/spyxfamily.jpg" alt="Product 3">
                //             <h3>Truyện 3</h3>
                //             <p class="price">150,000 VND</p>
                //             <button class="btn-add-to-cart">Thêm </button>
                //         </div><div class="product-item">
                //             <img src="view/layout/images/naruto.jpg" alt="Product 3">
                //             <h3>Truyện 3</h3>
                //             <p class="price">150,000 VND</p>
                //             <button class="btn-add-to-cart">Thêm </button>
                //         </div><div class="product-item">
                //             <img src="view/layout/images/chainsawman.jpg" alt="Product 3">
                //             <h3>Truyện 3</h3>
                //             <p class="price">150,000 VND</p>
                //             <button class="btn-add-to-cart">Thêm </button>
                //         </div>
                //         <!-- Thêm các sản phẩm khác tại đây -->
                //         ';
        ?>
    </div>  
</main>