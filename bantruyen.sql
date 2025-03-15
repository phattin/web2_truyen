-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 15, 2025 lúc 10:47 AM
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
  `Password` varchar(50) NOT NULL,
  `RoleID` varchar(10) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`Username`, `Password`, `RoleID`, `Status`) VALUES
('admin', 'admin123', 'R1', 'Hiện'),
('kh01', 'password02', 'R3', 'Hiện'),
('nv01', 'password01', 'R2', 'Hiện');

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
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`CustomerID`, `Fullname`, `Username`, `Email`, `Address`, `Phone`, `TotalSpending`, `Status`) VALUES
('C001', 'Nguyễn Văn A', 'kh01', 'nguyenvana@gmail.com', 'Hà Nội', '0987654321', 1500000, 'Hiện');

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
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employee`
--

INSERT INTO `employee` (`EmployeeID`, `Fullname`, `Username`, `BirthDay`, `Phone`, `Email`, `Address`, `Gender`, `Salary`, `StartDate`, `Status`) VALUES
('E001', 'Trần Văn B', 'nv01', '1990-05-20', '0981234567', 'tranvanb@gmail.com', 'Hồ Chí Minh', 'Nam', 7000000, '2024-01-01', 'Hiện');

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
('R1', 'F001', 'Thêm'),
('R1', 'F001', 'Sửa'),
('R1', 'F001', 'Xóa'),
('R2', 'F002', 'Thêm'),
('R2', 'F002', 'Sửa'),
('R2', 'F002', 'Xóa');

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
('G001', 'Hài hước'),
('G002', 'Trinh thám'),
('G003', 'Phiêu lưu');

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
('P002', 'G002');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_invoice`
--

CREATE TABLE `import_invoice` (
  `ImportID` varchar(10) NOT NULL,
  `EmployeeID` varchar(10) NOT NULL,
  `SupplierID` varchar(10) NOT NULL,
  `Date` date NOT NULL,
  `TotalPrice` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_invoice_detail`
--

CREATE TABLE `import_invoice_detail` (
  `ImportDetailID` varchar(10) NOT NULL,
  `ImportID` varchar(10) NOT NULL,
  `ProductID` varchar(10) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` int(10) NOT NULL,
  `TotalPrice` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Quantity` int(11) NOT NULL,
  `ROS` double NOT NULL,
  `Description` varchar(500) NOT NULL,
  `SupplierID` varchar(10) NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductImg`, `Author`, `Publisher`, `Quantity`, `ROS`, `Description`, `SupplierID`, `Status`) VALUES
('P001', 'Truyện Doremon', 'doremon.jpg', 'Fujiko F. Fujio', 'NXB Kim Đồng', 100, 1.2, 'Truyện tranh hài hước', 'S001', 'Hiện'),
('P002', 'Truyện Conan', 'conan.jpg', 'Gosho Aoyama', 'NXB Kim Đồng', 80, 1.5, 'Truyện trinh thám nổi tiếng', 'S002', 'Hiện');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotion`
--

CREATE TABLE `promotion` (
  `PromotionID` varchar(10) NOT NULL,
  `PromotionName` varchar(50) NOT NULL,
  `Discount` double NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `promotion`
--

INSERT INTO `promotion` (`PromotionID`, `PromotionName`, `Discount`, `Status`) VALUES
('PR01', 'Giảm giá Tết', 10, 'Hiện'),
('PR02', 'Khuyến mãi hè', 15, 'Hiện');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `ReviewsID` varchar(10) NOT NULL,
  `CustomerID` varchar(10) NOT NULL,
  `ProductID` varchar(10) NOT NULL,
  `Rating` double NOT NULL,
  `Comment` varchar(500) NOT NULL,
  `CreatedDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`ReviewsID`, `CustomerID`, `ProductID`, `Rating`, `Comment`, `CreatedDate`) VALUES
('RV001', 'C001', 'P001', 5, 'Truyện rất hay, đáng mua!', '2025-03-15');

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
('R1', 'Admin'),
('R2', 'Nhân viên'),
('R3', 'Khách hàng');

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
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sales_invoice`
--

INSERT INTO `sales_invoice` (`SalesID`, `EmployeeID`, `CustomerID`, `Date`, `PromotionID`, `TotalPrice`, `Status`) VALUES
('SI001', 'E001', 'C001', '2025-03-15', 'PR01', 1350000, 'Hiện');

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
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`, `Phone`, `Email`, `Address`, `Status`) VALUES
('S001', 'Nhà cung cấp A', '0123456789', 'nhaccA@gmail.com', 'Hà Nội', 'Hiện'),
('S002', 'Nhà cung cấp B', '0987654321', 'nhaccB@gmail.com', 'TP. Hồ Chí Minh', 'Hiện');

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
  ADD PRIMARY KEY (`ImportDetailID`),
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
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewsID`),
  ADD KEY `fk_customer_review` (`CustomerID`),
  ADD KEY `fk_product_review` (`ProductID`);

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
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_customer_review` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `fk_product_review` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

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
