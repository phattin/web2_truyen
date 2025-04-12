<?php
    require_once 'model/genreDB.php';
    $genres = genreDB::getAllGenre();
?>
<nav>
    <div class="container">
        <ul>
            <li><div class="menu-item" data-page="home" onclick="setActive(this)">Trang chủ</div></li>
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
