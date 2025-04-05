<?php
    $file_path = $_SERVER["DOCUMENT_ROOT"] . "/webbantruyen/model/connectDB.php";
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        die("Lỗi: Không tìm thấy file connectDB.php!");
    }
    class genreDB{
        private static $conn;
        public static function getAllGenre(){
            //Mở database
            $conn = connectDB::getConnection();
            //Lệnh sql
            $strSQL = 'Select * from genre';
            //Thực hiện sql
            $result = mysqli_query($conn, $strSQL);
            //Thực hiện chức năng
            $genreList = [];
            while($row = mysqli_fetch_assoc($result))
                $genreList[] = $row;
            //Đóng kết nối
            connectDB::closeConnection($conn);
            return $genreList;
        }

        // Thêm thể loại mới
        public function addGenre($id, $name) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "INSERT INTO genre (`GenreID`, `GenreName`) 
                        VALUES (?, ?)";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ss", $id, $name);
            //Thực hiện chức năng
            $success = $stmt->execute();

            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
            return $success;
        }

        //Sửa thể loại
        public function updateGenre($id, $name) {
            //Mở database
            $conn = ConnectDB::getConnection();
            //Lệnh sql
            $strSQL = "UPDATE genre SET GenreName = ?
                       WHERE GenreID = ?";
            //Thực hiện sql
            $stmt = $conn->prepare($strSQL);
            if (!$stmt) 
                die("Lỗi chuẩn bị SQL: " . $conn->error);
            $stmt->bind_param("ss", $name, $id);
            //Thực hiện chức năng
            $success = $stmt->execute();
            //Đóng kết nối
            $stmt->close();
            ConnectDB::closeConnection($conn);
        
            return $success;
        }

        //Lấy thể loại của sản phẩm
        public static function getGenresOfProduct($id) {
            // Mở database
            $conn = connectDB::getConnection();
            // Lệnh SQL đúng
            $strSQL = "SELECT * 
                       FROM genre
                       JOIN genre_detail ON genre.GenreID = genre_detail.GenreID 
                       WHERE genre_detail.ProductID = ?";
        
            // Thực hiện SQL
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            // Lưu danh sách sản phẩm
            $genreList = [];
            while ($row = $result->fetch_assoc()) 
                $genreList[] = $row;
            // Đóng kết nối
            connectDB::closeConnection($conn);
            return $genreList;
        }

        
    }
?>