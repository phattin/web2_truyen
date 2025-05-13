-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 13, 2025 lúc 06:12 PM
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
  `RoleID` varchar(10) NOT NULL,
  `IsDeleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`Username`, `Password`, `RoleID`, `IsDeleted`) VALUES
('admin', 'admin123', 'R001', 0),
('kh01', 'password02', 'R003', 0),
('nv01', 'password01', 'R002', 0),
('phattin', '$2y$10$LGxvas5xpea.HEvxLjVXxug4AdQaJnP5txgiDer2wNf2Fjy4W2KCy', 'R001', 0),
('phattin123', '$2y$10$U0q2hbQEySm2GG4ak93kJ.AThbIctl5iWNu0NqGek/XcQ8IZ6u/B2', 'R003', 0),
('tin', '$2y$10$2aX5DfDLqgukmqP7eKBY3OL/r0TW3kwQpxTc9ZbnoBlXiUZVGolqS', 'R003', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `catalogs`
--

CREATE TABLE `catalogs` (
  `CatalogsID` varchar(10) NOT NULL,
  `CatalogsName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `catalogs`
--

INSERT INTO `catalogs` (`CatalogsID`, `CatalogsName`) VALUES
('C001', 'Hot'),
('C002', 'Mới');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `catalogs_detail`
--

CREATE TABLE `catalogs_detail` (
  `ProductID` varchar(10) NOT NULL,
  `CatalogsID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `catalogs_detail`
--

INSERT INTO `catalogs_detail` (`ProductID`, `CatalogsID`) VALUES
('P001', 'C001'),
('P002', 'C002');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `CustomerID` varchar(10) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phone` varchar(25) NOT NULL,
  `TotalSpending` double NOT NULL,
  `IsDeleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`CustomerID`, `Fullname`, `Username`, `Email`, `Address`, `Phone`, `TotalSpending`, `IsDeleted`) VALUES
('C001', 'Nguyễn Văn A', 'kh01', 'nguyenvana@gmail.com', 'Hà Nội', '0987654321', 1500000, 0),
('C003', 'Nguyen Phat Tin', 'phattin123', 'phattin123@gmail.com', 'abc', '0987654321', 0, 0),
('C004', 'Phat Tin', 'tin', 'tin@gmail.com', '123456', '0987654321', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employee`
--

CREATE TABLE `employee` (
  `EmployeeID` varchar(10) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
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

INSERT INTO `employee` (`EmployeeID`, `Fullname`, `Username`, `BirthDay`, `Phone`, `Email`, `Address`, `Gender`, `Salary`, `StartDate`, `IsDeleted`) VALUES
('E001', 'Trần Văn B', 'nv01', '1990-05-20', '0981234567', 'tranvanb@gmail.com', 'Hồ Chí Minh', 'Nam', 7000000, '2024-01-01', 0),
('E002', 'Phát Tín', 'phattin', '2005-01-01', '0987654123', 'phattin@gmail.com', 'abc', 'Nam', 10000000, '2024-12-12', 0);

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
('F003', 'Bán hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `function_detail`
--

CREATE TABLE `function_detail` (
  `RoleID` varchar(10) NOT NULL,
  `FunctionID` varchar(10) NOT NULL,
  `Option` enum('Thêm','Sửa','Xóa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `function_detail`
--

INSERT INTO `function_detail` (`RoleID`, `FunctionID`, `Option`) VALUES
('R001', 'F001', 'Thêm'),
('R001', 'F001', 'Sửa'),
('R001', 'F001', 'Xóa'),
('R002', 'F002', 'Thêm'),
('R002', 'F002', 'Sửa'),
('R002', 'F002', 'Xóa');

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
  `ProductID` varchar(10) NOT NULL,
  `GenreID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `genre_detail`
--

INSERT INTO `genre_detail` (`ProductID`, `GenreID`) VALUES
('P001', 'G001'),
('P002', 'G002'),
('P001', 'G003'),
('P001', 'G025'),
('P001', 'G034'),
('P002', 'G016'),
('P002', 'G004'),
('P002', 'G003'),
('P002', 'G028'),
('P002', 'G021'),
('P001', 'G016'),
('P003', 'G016'),
('P003', 'G004'),
('P003', 'G001'),
('P003', 'G009'),
('P003', 'G011'),
('P003', 'G028'),
('P003', 'G033'),
('P003', 'G003'),
('P004', 'G016'),
('P004', 'G028'),
('P004', 'G011'),
('P004', 'G009'),
('P004', 'G001'),
('P004', 'G004'),
('P004', 'G033'),
('P004', 'G003'),
('P005', 'G016'),
('P005', 'G004'),
('P005', 'G011'),
('P005', 'G028'),
('P005', 'G033'),
('P006', 'G016'),
('P006', 'G028'),
('P006', 'G011'),
('P006', 'G009'),
('P006', 'G021'),
('P006', 'G004'),
('P006', 'G014'),
('P006', 'G003'),
('P007', 'G016'),
('P007', 'G028'),
('P007', 'G024'),
('P007', 'G009'),
('P007', 'G004'),
('P007', 'G023'),
('P008', 'G016'),
('P008', 'G028'),
('P008', 'G011'),
('P008', 'G001'),
('P008', 'G004'),
('P008', 'G033'),
('P008', 'G003'),
('P009', 'G016'),
('P009', 'G028'),
('P009', 'G011'),
('P009', 'G009'),
('P009', 'G001'),
('P009', 'G004'),
('P009', 'G033'),
('P009', 'G021'),
('P010', 'G016'),
('P010', 'G003'),
('P010', 'G011'),
('P010', 'G033'),
('P010', 'G023'),
('P010', 'G001');

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
('I013', 'P001', 10, 20000, 200000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `ProductID` varchar(10) NOT NULL,
  `ProductName` varchar(50) NOT NULL,
  `ProductImg` varchar(255) NOT NULL,
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

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductImg`, `Author`, `Publisher`, `Quantity`, `ImportPrice`, `ROS`, `Description`, `SupplierID`, `IsDeleted`) VALUES
('P001', 'Truyện Doremon', 'doremon.jpg', 'Fujiko F. Fujio', 'NXB Kim Đồng', 30, 20000, 1.2, 'Truyện tranh hài hước', 'S001', '0'),
('P002', 'Truyện Conan', 'conan.jpg', 'Gosho Aoyama', 'NXB Kim Đồng', 80, 40000, 1.5, 'Truyện trinh thám nổi tiếng', 'S002', '0'),
('P003', 'Truyện One Piece', 'onepiece.jpg', 'Eiichiro Oda', 'NXB Kim Đồng', 120, 22500, 1.3, 'Truyện phiêu lưu hành động', 'S003', '0'),
('P004', 'Truyện Naruto', 'naruto.jpg', 'Masashi Kishimoto', 'NXB Kim Đồng', 90, 27400, 1.4, 'Truyện ninja hấp dẫn', 'S004', '0'),
('P005', 'Truyện Dragon Ball', 'dragonball.jpg', 'Akira Toriyama', 'NXB Kim Đồng', 110, 25000, 1.6, 'Truyện võ thuật viễn tưởng', 'S005', '0'),
('P006', 'Truyện Attack on Titan', 'aot.jpg', 'Hajime Isayama', 'NXB Kim Đồng', 70, 48000, 1.8, 'Truyện hành động kịch tính', 'S006', '0'),
('P007', 'Truyện Tokyo Revengers', 'tokyo.jpg', 'Ken Wakui', 'NXB Kim Đồng', 85, 118000, 1.7, 'Truyện du hành thời gian', 'S007', '0'),
('P008', 'Truyện Jujutsu Kaisen', 'jujutsu.jpg', 'Gege Akutami', 'NXB Kim Đồng', 95, 150000, 1.5, 'Truyện chiến đấu huyền bí', 'S008', '0'),
('P009', 'Truyện Black Clover', 'blackclover.jpg', 'Yūki Tabata', 'NXB Kim Đồng', 75, 60000, 1.3, 'Truyện phép thuật hành động', 'S009', '0'),
('P010', 'Truyện Fairy Tail', 'fairytail.jpg', 'Hiro Mashima', 'NXB Kim Đồng', 88, 100000, 1.4, 'Truyện phiêu lưu phép thuật', 'S001', '0'),
('P011', 'abc', 'tốt.jpg', 'abc', 'abc', 0, 0, 0, '0', 'S001', '0');

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
('R003', 'Khách hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sales_invoice`
--

CREATE TABLE `sales_invoice` (
  `SalesID` varchar(10) NOT NULL,
  `EmployeeID` varchar(10) NOT NULL,
  `CustomerID` varchar(10) NOT NULL,
  `Date` date NOT NULL,
  `PromotionID` varchar(10) NOT NULL,
  `TotalPrice` int(10) NOT NULL,
  `IsDeleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sales_invoice`
--

INSERT INTO `sales_invoice` (`SalesID`, `EmployeeID`, `CustomerID`, `Date`, `PromotionID`, `TotalPrice`, `IsDeleted`) VALUES
('SI001', 'E001', 'C001', '2025-03-15', 'PR000', 1350000, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sales_invoice_detail`
--

CREATE TABLE `sales_invoice_detail` (
  `SalesDetailID` varchar(10) NOT NULL,
  `SalesID` varchar(10) NOT NULL,
  `ProductID` varchar(10) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` int(10) NOT NULL,
  `TotalPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sales_invoice_detail`
--

INSERT INTO `sales_invoice_detail` (`SalesDetailID`, `SalesID`, `ProductID`, `Quantity`, `Price`, `TotalPrice`) VALUES
('SD001', 'SI001', 'P001', 2, 50000, 100000),
('SD002', 'SI001', 'P002', 1, 45000, 45000);

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
  ADD KEY `fk_role` (`RoleID`);

--
-- Chỉ mục cho bảng `catalogs`
--
ALTER TABLE `catalogs`
  ADD PRIMARY KEY (`CatalogsID`);

--
-- Chỉ mục cho bảng `catalogs_detail`
--
ALTER TABLE `catalogs_detail`
  ADD PRIMARY KEY (`ProductID`,`CatalogsID`),
  ADD KEY `CatalogsID` (`CatalogsID`);

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
  ADD PRIMARY KEY (`EmployeeID`),
  ADD KEY `fk_account_employee` (`Username`);

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
  ADD KEY `fk_product_genre` (`ProductID`);

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
  ADD KEY `fk_supplier_product` (`SupplierID`);

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
  ADD KEY `fk_employee_sales` (`EmployeeID`),
  ADD KEY `fk_promotion` (`PromotionID`);

--
-- Chỉ mục cho bảng `sales_invoice_detail`
--
ALTER TABLE `sales_invoice_detail`
  ADD PRIMARY KEY (`SalesDetailID`),
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
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`);

--
-- Các ràng buộc cho bảng `catalogs_detail`
--
ALTER TABLE `catalogs_detail`
  ADD CONSTRAINT `catalogs_detail_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `catalogs_detail_ibfk_2` FOREIGN KEY (`CatalogsID`) REFERENCES `catalogs` (`CatalogsID`);

--
-- Các ràng buộc cho bảng `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_account_customer` FOREIGN KEY (`Username`) REFERENCES `account` (`Username`);

--
-- Các ràng buộc cho bảng `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `fk_account_employee` FOREIGN KEY (`Username`) REFERENCES `account` (`Username`);

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
  ADD CONSTRAINT `fk_product_genre` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

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
  ADD CONSTRAINT `fk_supplier_product` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`);

--
-- Các ràng buộc cho bảng `sales_invoice`
--
ALTER TABLE `sales_invoice`
  ADD CONSTRAINT `fk_customer_sales` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `fk_employee_sales` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`),
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
