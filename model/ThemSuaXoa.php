<?php
class ThemSuaXoa{

    private function getConnection(){
        $servername = "localhost:3306";  
        $username = "root";        
        $password = "";             
        $database = "bantruyen"; 

        try{
            // Kết nối MySQL
            $conn = mysqli_connect($servername, $username, $password, $database);
        
            // Kiểm tra lỗi kết nối
            if ($conn->connect_error) 
                die("Kết nối thất bại: " . $conn->connect_error);
        } catch(mysqli_sql_exception $e){
            die("Lỗi kết nối: " . $e->getMessage());
        }
        
        return $conn;
    }

    private function closeConnection($conn){
        if($conn!=null)
            mysqli_close($conn);
    }

    public function Them($sql){
        mysqli_query($this->getConnection(),$sql);
    }
}
?>