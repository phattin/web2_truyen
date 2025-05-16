-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 16, 2025 lúc 08:36 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `bantruyen`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `EmployeeID` varchar(10) NOT NULL,
  `RoleID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`Username`, `Password`, `EmployeeID`, `RoleID`) VALUES
('phattin', '$2y$10$LGxvas5xpea.HEvxLjVXxug4AdQaJnP5txgiDer2wNf2Fjy4W2KCy', 'E002', 'R001'),
('thanhthinh', '$2y$10$yazozBFHRM3iUq6KIUy.7utB.7lQTi0UnA4yoLiT2q.pzhzCs4ldq', 'E003', 'R004');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `CategoryID` varchar(10) NOT NULL,
  `CategoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`) VALUES
('CG001', 'Truyện tranh siêu nhiên Nhật Bản'),
('CG002', 'Truyện tranh trinh thám Nhật Bản'),
('CG003', 'Truyện tranh tình cảm Hàn Quốc'),
('CG004', 'Truyện tranh thiếu nhi Nhật Bản');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `CustomerID` varchar(10) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(500) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phone` varchar(25) NOT NULL,
  `TotalSpending` double NOT NULL,
  `IsBlocked` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`CustomerID`, `Fullname`, `Username`, `Password`, `Email`, `Address`, `Phone`, `TotalSpending`, `IsBlocked`) VALUES
('C005', 'Nguyen Thang', 'thang', '$2y$10$OdZFhQio0aHXl719tt7Fb.Nje69MZSRwVvAP2C35svbuxHOW.AlJW', 'thang@gmail.com', '12345', '0987456123', 0, 0),
('C006', 'Tung Thien', 'tungthien', '$2y$10$qSc.hbEQ.E2vk5H/.vm2lO2A2CEJeTnd4ErGEo4MkOhUUZxKySLGC', 'thien@gmail.com', '123, Quận 2, Hồ Chí Minh', '0987123444', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employee`
--

CREATE TABLE `employee` (
  `EmployeeID` varchar(10) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `BirthDay` date NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Gender` enum('Nam','Nữ') NOT NULL,
  `Salary` int(10) NOT NULL,
  `StartDate` date NOT NULL,
  `IsDeleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employee`
--

INSERT INTO `employee` (`EmployeeID`, `Fullname`, `BirthDay`, `Phone`, `Email`, `Address`, `Gender`, `Salary`, `StartDate`, `IsDeleted`) VALUES
('E001', 'Trần Văn A', '1990-05-20', '0981234567', 'tranvanb@gmail.com', 'Hồ Chí Minh', 'Nam', 700000, '2024-01-01', 1),
('E002', 'Phát Tín', '2005-01-01', '0987654123', 'phattin@gmail.com', 'abc', 'Nam', 10000000, '2024-12-12', 0),
('E003', 'Thanh Thinh', '2005-10-12', '0978456321', 'thinh@gmail.com', '123/123', 'Nam', 10000000, '2025-05-16', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `function`
--

CREATE TABLE `function` (
  `FunctionID` varchar(10) NOT NULL,
  `FunctionName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `function`
--

INSERT INTO `function` (`FunctionID`, `FunctionName`) VALUES
('F001', 'Quản lý tài khoản'),
('F002', 'Quản lý sản phẩm'),
('F003', 'Nhập hàng'),
('F004', 'Hóa đơn bán'),
('F005', 'Quản lý nhân viên'),
('F006', 'Quản lí khách hàng'),
('F007', 'Phân quyền'),
('F008', 'Quản lý chủng loại'),
('F009', 'Quản lý khuyến mãi'),
('F010', 'Quản lý nhà cung cấp'),
('F011', 'Thống kê');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `function_detail`
--

CREATE TABLE `function_detail` (
  `RoleID` varchar(10) NOT NULL,
  `FunctionID` varchar(10) NOT NULL,
  `Option` enum('Xem','Thêm','Sửa','Xóa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `function_detail`
--

INSERT INTO `function_detail` (`RoleID`, `FunctionID`, `Option`) VALUES
('R002', 'F001', 'Xem'),
('R002', 'F001', 'Thêm'),
('R002', 'F002', 'Xem'),
('R004', 'F002', 'Xem'),
('R004', 'F002', 'Thêm'),
('R004', 'F002', 'Sửa'),
('R004', 'F002', 'Xóa'),
('R004', 'F003', 'Xem'),
('R004', 'F003', 'Thêm'),
('R004', 'F003', 'Sửa'),
('R001', 'F001', 'Xem'),
('R001', 'F001', 'Thêm'),
('R001', 'F001', 'Sửa'),
('R001', 'F001', 'Xóa'),
('R001', 'F002', 'Xem'),
('R001', 'F002', 'Thêm'),
('R001', 'F002', 'Sửa'),
('R001', 'F002', 'Xóa'),
('R001', 'F003', 'Xem'),
('R001', 'F003', 'Thêm'),
('R001', 'F003', 'Sửa'),
('R001', 'F004', 'Xem'),
('R001', 'F005', 'Xem'),
('R001', 'F005', 'Thêm'),
('R001', 'F005', 'Sửa'),
('R001', 'F005', 'Xóa'),
('R001', 'F006', 'Xem'),
('R001', 'F006', 'Sửa'),
('R001', 'F006', 'Xóa'),
('R001', 'F007', 'Xem'),
('R001', 'F007', 'Thêm'),
('R001', 'F007', 'Sửa'),
('R001', 'F007', 'Xóa'),
('R001', 'F008', 'Xem'),
('R001', 'F008', 'Thêm'),
('R001', 'F008', 'Sửa'),
('R001', 'F008', 'Xóa'),
('R001', 'F009', 'Xem'),
('R001', 'F009', 'Thêm'),
('R001', 'F009', 'Sửa'),
('R001', 'F009', 'Xóa'),
('R001', 'F010', 'Xem'),
('R001', 'F010', 'Thêm'),
('R001', 'F010', 'Sửa'),
('R001', 'F010', 'Xóa'),
('R001', 'F011', 'Xem');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genre`
--

CREATE TABLE `genre` (
  `GenreID` varchar(10) NOT NULL,
  `GenreName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `genre`
--

INSERT INTO `genre` (`GenreID`, `GenreName`) VALUES
('G001', 'Comedy'),
('G002', 'Detective'),
('G003', 'Adventure'),
('G004', 'Action'),
('G005', 'Anime'),
('G006', 'Isekai'),
('G007', 'Ancient'),
('G008', 'Doujinshi'),
('G009', 'Drama'),
('G010', 'Boylove'),
('G011', 'Fantasy'),
('G012', 'Gender Bender'),
('G013', 'Historical'),
('G014', 'Horror'),
('G015', 'Live action'),
('G016', 'Manga'),
('G017', 'Manhua'),
('G018', 'Manhwa'),
('G019', 'Martial Arts'),
('G020', 'Mecha'),
('G021', 'Mystery'),
('G022', 'Psychological'),
('G023', 'Romance'),
('G024', 'School Life'),
('G025', 'Sci-fi'),
('G026', 'Shoujo'),
('G027', 'Shoujo Ai'),
('G028', 'Shounen'),
('G029', 'Shounen Ai'),
('G030', 'Xuyên không'),
('G031', 'Slice of Life'),
('G032', 'Sports'),
('G033', 'Supernatural'),
('G034', 'Kids'),
('G035', 'Tragedy'),
('G036', 'Truyện Màu'),
('G037', 'Webtoon'),
('G038', 'Tu tiên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genre_detail`
--

CREATE TABLE `genre_detail` (
  `CategoryID` varchar(10) NOT NULL,
  `GenreID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `genre_detail`
--

INSERT INTO `genre_detail` (`CategoryID`, `GenreID`) VALUES
('CG004', 'G001'),
('CG002', 'G002'),
('CG004', 'G003'),
('CG004', 'G025'),
('CG004', 'G034'),
('CG002', 'G016'),
('CG002', 'G004'),
('CG002', 'G003'),
('CG002', 'G028'),
('CG002', 'G021'),
('CG004', 'G016'),
('CG001', 'G016'),
('CG001', 'G004'),
('CG001', 'G001'),
('CG001', 'G009'),
('CG001', 'G011'),
('CG001', 'G028'),
('CG001', 'G033'),
('CG001', 'G003'),
('CG004', 'G001'),
('CG002', 'G002'),
('CG004', 'G003'),
('CG004', 'G025'),
('CG004', 'G034'),
('CG002', 'G016'),
('CG002', 'G004'),
('CG002', 'G003'),
('CG002', 'G028'),
('CG002', 'G021'),
('CG004', 'G016'),
('CG001', 'G016'),
('CG001', 'G004'),
('CG001', 'G001'),
('CG001', 'G009'),
('CG001', 'G011'),
('CG001', 'G028'),
('CG001', 'G033'),
('CG001', 'G003');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_invoice`
--

CREATE TABLE `import_invoice` (
  `ImportID` varchar(10) NOT NULL,
  `EmployeeID` varchar(10) NOT NULL,
  `SupplierID` varchar(10) NOT NULL,
  `Date` date NOT NULL,
  `TotalPrice` int(10) NOT NULL,
  `ROS` float NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `import_invoice`
--

INSERT INTO `import_invoice` (`ImportID`, `EmployeeID`, `SupplierID`, `Date`, `TotalPrice`, `ROS`, `Status`) VALUES
('I001', 'E001', 'S001', '2024-12-05', 20000000, 1.4, 'Đã nhận'),
('I002', 'E001', 'S002', '2024-12-05', 3200000, 1.3, 'Đã nhận'),
('I003', 'E001', 'S003', '2024-12-05', 2700000, 1.5, 'Đã nhận'),
('I004', 'E001', 'S004', '2024-12-05', 2466000, 1.3, 'Đã nhận'),
('I005', 'E001', 'S005', '2024-12-05', 2750000, 1.3, 'Đã nhận'),
('I006', 'E001', 'S006', '2024-12-05', 3360000, 1.4, 'Đã nhận'),
('I007', 'E001', 'S007', '2024-12-05', 10030000, 1.5, 'Đã nhận'),
('I008', 'E001', 'S008', '2024-12-05', 14250000, 1.6, 'Đã nhận'),
('I009', 'E001', 'S009', '2024-12-05', 4500000, 1.3, 'Đã nhận'),
('I010', 'E002', 'S001', '2025-05-13', 200000, 1, 'Đã nhận'),
('I011', 'E002', 'S001', '2025-05-13', 600000, 0.9, 'Đã hủy'),
('I012', 'E002', 'S001', '2025-05-13', 200000, 1, 'Đã nhận'),
('I013', 'E002', 'S001', '2025-05-13', 200000, 1.2, 'Đã nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_invoice_detail`
--

CREATE TABLE `import_invoice_detail` (
  `ImportID` varchar(10) NOT NULL,
  `ProductID` varchar(10) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` int(10) NOT NULL,
  `TotalPrice` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `import_invoice_detail`
--

INSERT INTO `import_invoice_detail` (`ImportID`, `ProductID`, `Quantity`, `Price`, `TotalPrice`) VALUES
('I001', 'P001', 100, 20000, 2000000),
('I001', 'P010', 88, 100000, 8800000),
('I002', 'P002', 80, 40000, 3200000),
('I003', 'P003', 120, 22500, 2700000),
('I004', 'P004', 90, 27400, 2466000),
('I005', 'P005', 110, 25000, 2750000),
('I006', 'P006', 70, 48000, 3360000),
('I007', 'P007', 85, 118000, 10030000),
('I008', 'P008', 95, 150000, 14250000),
('I009', 'P009', 75, 60000, 4500000),
('I010', 'P001', 10, 20000, 200000),
('I011', 'P001', 30, 20000, 600000),
('I012', 'P001', 10, 20000, 200000),
('I013', 'P001', 10, 20000, 200000),
('I001', 'P001', 100, 20000, 2000000),
('I001', 'P010', 88, 100000, 8800000),
('I002', 'P002', 80, 40000, 3200000),
('I003', 'P003', 120, 22500, 2700000),
('I004', 'P004', 90, 27400, 2466000),
('I005', 'P005', 110, 25000, 2750000),
('I006', 'P006', 70, 48000, 3360000),
('I007', 'P007', 85, 118000, 10030000),
('I008', 'P008', 95, 150000, 14250000),
('I009', 'P009', 75, 60000, 4500000),
('I010', 'P001', 10, 20000, 200000),
('I011', 'P001', 30, 20000, 600000),
('I012', 'P001', 10, 20000, 200000),
('I013', 'P001', 10, 20000, 200000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `ProductID` varchar(10) NOT NULL,
  `ProductName` varchar(50) NOT NULL,
  `ProductImg` varchar(255) NOT NULL,
  `CategoryID` varchar(10) NOT NULL,
  `Author` varchar(50) NOT NULL,
  `Publisher` varchar(50) NOT NULL,
  `Quantity` int(5) NOT NULL,
  `ImportPrice` int(10) NOT NULL,
  `ROS` double NOT NULL,
  `Description` varchar(500) NOT NULL,
  `SupplierID` varchar(10) NOT NULL,
  `IsDeleted` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductImg`, `CategoryID`, `Author`, `Publisher`, `Quantity`, `ImportPrice`, `ROS`, `Description`, `SupplierID`, `IsDeleted`) VALUES
('P001', 'Truyện Doremon', 'doremon.jpg', 'CG004', 'Fujiko F. Fujio', 'NXB Kim Đồng', 30, 20000, 1.2, 'Truyện tranh hài hước', 'S001', '0'),
('P002', 'Truyện Conan', 'conan.jpg', 'CG002', 'Gosho Aoyama', 'NXB Kim Đồng', 80, 40000, 1.5, 'Truyện trinh thám nổi tiếng', 'S002', '0'),
('P003', 'Truyện One Piece', 'onepiece.jpg', 'CG001', 'Eiichiro Oda', 'NXB Kim Đồng', 120, 22500, 1.3, 'Truyện phiêu lưu hành động', 'S003', '0'),
('P004', 'Truyện Naruto', 'naruto.jpg', 'CG001', 'Masashi Kishimoto', 'NXB Kim Đồng', 90, 27400, 1.4, 'Truyện ninja hấp dẫn', 'S004', '0'),
('P005', 'Truyện Dragon Ball', 'dragonball.jpg', 'CG001', 'Akira Toriyama', 'NXB Kim Đồng', 110, 25000, 1.6, 'Truyện võ thuật viễn tưởng', 'S005', '0'),
('P006', 'Truyện Attack on Titan', 'aot.jpg', 'CG001', 'Hajime Isayama', 'NXB Kim Đồng', 70, 48000, 1.8, 'Truyện hành động kịch tính', 'S006', '0'),
('P007', 'Truyện Tokyo Revengers', 'tokyo.jpg', 'CG001', 'Ken Wakui', 'NXB Kim Đồng', 85, 118000, 1.7, 'Truyện du hành thời gian', 'S007', '0'),
('P008', 'Truyện Jujutsu Kaisen', 'jujutsu.jpg', 'CG001', 'Gege Akutami', 'NXB Kim Đồng', 95, 150000, 1.5, 'Truyện chiến đấu huyền bí', 'S008', '0'),
('P009', 'Truyện Black Clover', 'blackclover.jpg', 'CG001', 'Yūki Tabata', 'NXB Kim Đồng', 75, 60000, 1.3, 'Truyện phép thuật hành động', 'S009', '0'),
('P010', 'Truyện Fairy Tail', 'fairytail.jpg', 'CG001', 'Hiro Mashima', 'NXB Kim Đồng', 88, 100000, 1.4, 'Truyện phiêu lưu phép thuật', 'S001', '0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotion`
--

CREATE TABLE `promotion` (
  `PromotionID` varchar(10) NOT NULL,
  `PromotionName` varchar(50) NOT NULL,
  `Discount` double NOT NULL,
  `StartDate` date NOT NULL DEFAULT current_timestamp(),
  `EndDate` date NOT NULL DEFAULT current_timestamp(),
  `IsDeleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `promotion`
--

INSERT INTO `promotion` (`PromotionID`, `PromotionName`, `Discount`, `StartDate`, `EndDate`, `IsDeleted`) VALUES
('PR000', 'Không áp dụng khuyển mãi', 0, '2000-01-01', '3000-01-01', 0),
('PR001', 'Giảm giá Tết', 20, '2024-05-01', '2025-05-30', 0),
('PR002', 'Khuyến mãi hè', 15, '2025-05-01', '2025-05-13', 0),
('PR003', 'aaa', 11, '2025-05-05', '2025-05-17', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `RoleID` varchar(10) NOT NULL,
  `RoleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`RoleID`, `RoleName`) VALUES
('R001', 'Admin'),
('R002', 'Nhân viên'),
('R003', 'Khách hàng'),
('R004', 'Nhân viên nhập hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sales_invoice`
--

CREATE TABLE `sales_invoice` (
  `SalesID` varchar(10) NOT NULL,
  `CustomerID` varchar(10) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `PromotionID` varchar(10) NOT NULL,
  `TotalPrice` int(10) NOT NULL,
  `PaymentMethod` varchar(255) NOT NULL,
  `Note` varchar(500) NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sales_invoice`
--

INSERT INTO `sales_invoice` (`SalesID`, `CustomerID`, `Phone`, `Address`, `Date`, `PromotionID`, `TotalPrice`, `PaymentMethod`, `Note`, `Status`) VALUES
('SI002', 'C005', '0987456123', '123ABC, Quận 5, HCM', '2025-05-16', 'PR001', 156600, 'Tiền mặt', '', 'Chưa xác nhận'),
('SI003', 'C005', '0987456123', '12345, Quận 1, HCM', '2025-05-16', 'PR000', 239750, 'Tiền mặt', '', 'Chưa xác nhận'),
('SI004', 'C006', '0987123444', '123A, Quận 10, HCM', '2025-05-16', 'PR000', 144000, 'Tiền mặt', '', 'Chưa xác nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sales_invoice_detail`
--

CREATE TABLE `sales_invoice_detail` (
  `SalesID` varchar(10) NOT NULL,
  `ProductID` varchar(10) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` int(10) NOT NULL,
  `TotalPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sales_invoice_detail`
--

INSERT INTO `sales_invoice_detail` (`SalesID`, `ProductID`, `Quantity`, `Price`, `TotalPrice`) VALUES
('SI002', 'P001', 1, 44000, 44000),
('SI002', 'P002', 1, 100000, 100000),
('SI002', 'P003', 1, 51750, 51750),
('SI003', 'P001', 2, 44000, 88000),
('SI003', 'P002', 1, 100000, 100000),
('SI003', 'P003', 1, 51750, 51750),
('SI004', 'P001', 1, 44000, 44000),
('SI004', 'P002', 1, 100000, 100000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` varchar(10) NOT NULL,
  `SupplierName` varchar(50) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `IsDeleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`, `Phone`, `Email`, `Address`, `IsDeleted`) VALUES
('S001', 'Nhà cung cấp A', '0123456789', 'nhaccA@gmail.com', 'Hà Nội', 0),
('S002', 'Nhà cung cấp B', '0987654321', 'nhaccB@gmail.com', 'TP. Hồ Chí Minh', 0),
('S003', 'Nhà cung cấp 3', '', '', '', 0),
('S004', 'Nhà cung cấp 4', '', '', '', 0),
('S005', 'Nhà cung cấp 5', '', '', '', 0),
('S006', 'Nhà cung cấp 6', '', '', '', 0),
('S007', 'Nhà cung cấp 7', '', '', '', 0),
('S008', 'Nhà cung cấp 8', '', '', '', 0),
('S009', 'Nhà cung cấp 9', '', '', '', 0),
('S010', 'Nhà cung cấp 10', '', '', '', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`Username`),
  ADD KEY `fk_role` (`RoleID`),
  ADD KEY `fk_account_employee` (`EmployeeID`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`),
  ADD KEY `fk_account_customer` (`Username`);

--
-- Chỉ mục cho bảng `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Chỉ mục cho bảng `function`
--
ALTER TABLE `function`
  ADD PRIMARY KEY (`FunctionID`);

--
-- Chỉ mục cho bảng `function_detail`
--
ALTER TABLE `function_detail`
  ADD KEY `fk_function_fd` (`FunctionID`),
  ADD KEY `fk_role_fd` (`RoleID`);

--
-- Chỉ mục cho bảng `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`GenreID`);

--
-- Chỉ mục cho bảng `genre_detail`
--
ALTER TABLE `genre_detail`
  ADD KEY `fk_genre` (`GenreID`),
  ADD KEY `fk_genre_category` (`CategoryID`);

--
-- Chỉ mục cho bảng `import_invoice`
--
ALTER TABLE `import_invoice`
  ADD PRIMARY KEY (`ImportID`),
  ADD KEY `fk_employee_import` (`EmployeeID`),
  ADD KEY `fk_supplier_import` (`SupplierID`);

--
-- Chỉ mục cho bảng `import_invoice_detail`
--
ALTER TABLE `import_invoice_detail`
  ADD KEY `fk_import` (`ImportID`),
  ADD KEY `fk_product_import` (`ProductID`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `fk_supplier_product` (`SupplierID`),
  ADD KEY `fk_product_category` (`CategoryID`);

--
-- Chỉ mục cho bảng `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`PromotionID`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Chỉ mục cho bảng `sales_invoice`
--
ALTER TABLE `sales_invoice`
  ADD PRIMARY KEY (`SalesID`),
  ADD KEY `fk_customer_sales` (`CustomerID`),
  ADD KEY `fk_promotion` (`PromotionID`);

--
-- Chỉ mục cho bảng `sales_invoice_detail`
--
ALTER TABLE `sales_invoice_detail`
  ADD KEY `fk_sales` (`SalesID`),
  ADD KEY `fk_product_sales` (`ProductID`);

--
-- Chỉ mục cho bảng `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `fk_account_employee` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`),
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`);

--
-- Các ràng buộc cho bảng `function_detail`
--
ALTER TABLE `function_detail`
  ADD CONSTRAINT `fk_function_fd` FOREIGN KEY (`FunctionID`) REFERENCES `function` (`FunctionID`),
  ADD CONSTRAINT `fk_role_fd` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`);

--
-- Các ràng buộc cho bảng `genre_detail`
--
ALTER TABLE `genre_detail`
  ADD CONSTRAINT `fk_genre` FOREIGN KEY (`GenreID`) REFERENCES `genre` (`GenreID`),
  ADD CONSTRAINT `fk_genre_category` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);

--
-- Các ràng buộc cho bảng `import_invoice`
--
ALTER TABLE `import_invoice`
  ADD CONSTRAINT `fk_employee_import` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`),
  ADD CONSTRAINT `fk_supplier_import` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`);

--
-- Các ràng buộc cho bảng `import_invoice_detail`
--
ALTER TABLE `import_invoice_detail`
  ADD CONSTRAINT `fk_import` FOREIGN KEY (`ImportID`) REFERENCES `import_invoice` (`ImportID`),
  ADD CONSTRAINT `fk_product_import` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`),
  ADD CONSTRAINT `fk_supplier_product` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`);

--
-- Các ràng buộc cho bảng `sales_invoice`
--
ALTER TABLE `sales_invoice`
  ADD CONSTRAINT `fk_customer_sales` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `fk_promotion` FOREIGN KEY (`PromotionID`) REFERENCES `promotion` (`PromotionID`);

--
-- Các ràng buộc cho bảng `sales_invoice_detail`
--
ALTER TABLE `sales_invoice_detail`
  ADD CONSTRAINT `fk_product_sales` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `fk_sales` FOREIGN KEY (`SalesID`) REFERENCES `sales_invoice` (`SalesID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
