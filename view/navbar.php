<?php
    require_once 'model/genreDB.php';
    $genres = genreDB::getAllGenre();
?>
<nav>
    <div class="container">
        <ul>
            <li><div class="menu-item active" data-page="home" onclick="setActive(this)">Tất cả</div></li>
            <li class="dropdown">
                <div class="menu-item" >Thể loại ▼</div>
                <div class="dropdown-menu">
                    <ul class="dropdown-menu-list">
                        <?php
                        foreach ($genres as $genre) {
                            echo '<li data-mode="genre" data-genre="'.$genre["GenreID"].'" class="menu-list-genre"><div>'.$genre["GenreName"].'</div></li>';
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <li><div class="menu-item" data-page="Hot">Hot</div></li>
            <li><div class="menu-item" data-page="New">New</div></li>
        </ul>
    </div>
</nav>
<div class="filter-bar">
    <div class="filter-header">Bộ lọc:</div>
    <ul class="filter-list">
        <li class="filter-item">
        <div class="filter-item" >Thể loại ▼</div>
            <div class="dropdown-filter">
                <ul class="dropdown-filter-list">
                    <?php
                    foreach ($genres as $genre) {
                        echo '<li class="filter-list-genre"><label for="'.$genre["GenreID"].'">'.$genre["GenreName"].'</label> <input id="'.$genre["GenreID"].'" type="checkbox"> </li>';
                    }
                    ?>
                </ul>
            </div>
        </li>
        <li class="filter-item"><label for="new-filter">Truyện mới</label> <input id="new-filter" type="checkbox"></li>
        <li class="filter-item"><label for="hot-filter">Truyện hot</label> <input id="hot-filter" type="checkbox"></li>
        <li class="filter-item">Giá:  
            <span class="filter-price-range">
                <input type="number" id="min-price" placeholder="Từ" min="0"> -
                <input type="number" id="max-price" placeholder="Đến" min="0">
            </span>
        </li>
    </ul>
    <button class="filter-button">Lọc</button>
</div>
