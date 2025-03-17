<?php
    require 'model/genreDB.php';
    $genres = genreDB::getAllGenre();
?>
<nav>
    <div class="container">
        <ul>
            <li><a href="index.php?trangChu">Trang chủ</a></li>
            <li class="dropdown">
                <a>Thể loại ▼</a>
                <div class="dropdown-menu">
                    <ul class="dropdown-menu-list">
                        <?php
                        foreach ($genres as $genre) {
                            echo '<li><a href="?genre='.$genre["GenreID"].'">'.$genre["GenreName"].'</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <li><a href="#">Hot</a></li>
            <li><a href="#">New</a></li>
        </ul>
    </div>
</nav>