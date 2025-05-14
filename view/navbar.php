<?php
    require_once 'model/genreDB.php';
    $genres = genreDB::getAllGenre();
    require_once 'model/categoryDB.php';
    $categories = categoryDB::getAllCategory();
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
            <li class="dropdown">
                <div class="menu-item" >Chủng loại ▼</div>
                <div class="dropdown-menu">
                    <ul class="dropdown-menu-list">
                        <?php
                        foreach ($categories as $category) {
                            echo '<li data-mode="category" data-category="'.$category["CategoryID"].'" class="menu-list-category"><div>'.$category["CategoryName"].'</div></li>';
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <li><div class="menu-list-genre" data-mode="genre" data-genre="G016">Manga</div></li>
            <li><div class="menu-list-genre" data-mode="genre" data-genre="G018">Manhwa</div></li>
        </ul>
    </div>
</nav>
<div class="filter-bar">
    <div class="filter-header">Bộ lọc:</div>
    <ul class="filter-list">
        <li class="filter-item">
            <input type="text" placeholder="Tìm tên truyện" id="filter-search">
        </li>
        <li class="filter-item">
            <div class="filter-item" >Chủng loại ▼</div>
            <div class="dropdown-filter">
                <ul class="dropdown-filter-list" style="display: block;">
                    <?php
                    foreach ($categories as $category) {
                        echo '<li class="filter-list-category"><label for="'.$category["CategoryID"].'">'.$category["CategoryName"].'</label> <input id="'.$category["CategoryID"].'" type="checkbox"> </li>';
                    }
                    ?>
                </ul>
            </div>
        </li>
        
        <li class="filter-item">Giá:  
            <span class="filter-price-range">
                <input type="number" id="min-price" placeholder="Từ" min="0"> -
                <input type="number" id="max-price" placeholder="Đến" min="0">
            </span>
        </li>
    </ul>
    <button class="filter-button">Lọc</button>
</div>
