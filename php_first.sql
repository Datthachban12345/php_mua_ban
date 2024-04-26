-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 26, 2024 lúc 05:32 AM
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
-- Cơ sở dữ liệu: `php_first`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `add_category`
--

CREATE TABLE `add_category` (
  `id` int(11) NOT NULL,
  `category` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `add_category`
--

INSERT INTO `add_category` (`id`, `category`) VALUES
(1, 'sách'),
(2, 'phim'),
(3, 'báo'),
(4, 'game'),
(16, 'quần');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id_cart`, `product_id`, `quantity`, `id_user`) VALUES
(60, 6, 1, 5),
(63, 8, 1, 10),
(64, 8, 1, 10),
(65, NULL, 1, 10),
(66, 5, 1, 10),
(68, NULL, 4, 10),
(69, NULL, 6, 10),
(70, 24, 2, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `id_comment` int(11) NOT NULL,
  `noidung` varchar(200) DEFAULT NULL,
  `user_Id` int(11) DEFAULT NULL,
  `product_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `logintoken`
--

CREATE TABLE `logintoken` (
  `id` int(11) NOT NULL,
  `user_Id` int(11) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `img` varchar(200) DEFAULT NULL,
  `nameProduct` varchar(100) NOT NULL DEFAULT 'coming soon',
  `price` varchar(200) DEFAULT NULL,
  `priceNew` varchar(200) DEFAULT 'đang cập nhật',
  `describes` text DEFAULT NULL,
  `category` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `img`, `nameProduct`, `price`, `priceNew`, `describes`, `category`) VALUES
(5, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', 'kamen rider', '30.000', '20.000', NULL, 'sách,báo'),
(6, 'https://th.bing.com/th/id/OIP.2PxIPMmLb7qXuO-18GWOBAHaEK?w=271&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7', 'kamen rider', '30.000', '20.000', NULL, 'phim'),
(7, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', 'super sentai', '245.000.000', '145.000.000', NULL, 'game'),
(8, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', 'super sentai gao ồ gao ồ gao super sentai tèn ten\r\n', '2.000', '1.000', NULL, 'phim'),
(9, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', '2', '50.000.000', '40.000.000', NULL, 'sách'),
(10, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', '2', '2.000', '1.000', NULL, 'sách'),
(11, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', '3', '3.000', '2.500', NULL, 'phim'),
(12, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', '3', '300.000.000', '10.000', NULL, 'game'),
(13, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', 'giấc mơ', '500', '100', NULL, 'game'),
(14, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', 'giấc mơ', '10', '1', NULL, 'sách'),
(15, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', 'của em', '7.000.000', '20.000', NULL, 'phim'),
(16, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', 'của em', '7.000.000', '6.999.000', NULL, 'game'),
(17, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', 'là những giấc mơ', '10.000', '', NULL, 'sách'),
(18, 'https://donoithatdanang.com/wp-content/uploads/2021/11/20-hinh-anh-anime-nam-buon-khoc-lanh-lung-anime-boy-images-hd-2.jpg', 'là những giấc mơ', '12.000', '11.000', NULL, 'phim'),
(19, 'https://down-vn.img.susercontent.com/file/1e7414cb3f31b139e2c7f90c1b03e4e0', 'Sách Tô Màu - 999 Lá Thư Gửi Cho Chính Mình - Tô Màu Cuộc Sống', '99.000', '69.000', 'Chúng mình đều biết những sắc màu của cuộc sống đều bắt nguồn từ những điều bình dị và thường nhật nhất xung quanh mà ta vẫn thường tiếp xúc mỗi ngày: như bầu trời xanh ngát, như áng mây trắng tinh, như ánh nắng phủ vàng lên những đóa hoa hồng ngọt… Thế nhưng nhịp sống hàng ngày của chúng ta luôn trôi qua trong sự vội vã, những bộn bề hóa thành “bộ lọc” biến bức tranh cuộc sống muôn màu kia trở nên ảm đạm và phủ đầy âu lo, khiến ta dường như quên lãng việc phải khám phá ra những vẻ đẹp thuần khiết của vạn vật, quên mất rằng thế giới mà chúng ta đang sống cũng có những điều nhỏ nhặt đáng quý và đáng yêu biết nhường nào. \r\n\r\n\r\n\r\nHiểu thấu được điều đó, “999 lá thư gửi cho chính mình” – Phiên bản “Tô màu cuộc sống” chính thức ra đời với sứ mệnh mang đến cho cuộc sống của bạn thêm nhiều điều hạnh phúc ngọt ngào thông qua những lá thư đầy ý nghĩa kết hợp cùng những bức tranh sinh động nhất đợi bạn đặt bút tô điểm. Đến với cuốn sách này, chúng mình mong rằng bạn có thể tự tay vẽ nên những giấc mơ của riêng bạn, những giây phút thăng hoa trong cuộc sống, có thể tô điểm thêm cho những khoảnh khắc đời thường trở nên rực rỡ và muôn phần lộng lẫy hơn. Mong rằng những gam màu ấm áp và tươi vui do chính tay bạn tô vẽ có thể xoa dịu và chữa lành những bất an bên trong bạn, để thế giới xung quanh bạn trở nên muôn màu muôn vẻ, mang không khí tươi trẻ và nhiệt huyết ngập tràn, đón ánh ban mai và vui sống! ', 'tô màu'),
(20, 'https://down-vn.img.susercontent.com/file/1e7414cb3f31b139e2c7f90c1b03e4e0', 'Sách Tô Màu - 998 Lá Thư Gửi Cho Chính Mình - Tô Màu Cuộc Sống', '99.000', '69.000', 'Chúng mình đều biết những sắc màu của cuộc sống đều bắt nguồn từ những điều bình dị và thường nhật nhất xung quanh mà ta vẫn thường tiếp xúc mỗi ngày: như bầu trời xanh ngát, như áng mây trắng tinh, n', 'tô màu'),
(23, 'https://down-vn.img.susercontent.com/file/sg-11134201-22120-j3f66g7sblkv73', 'SÁCH TÔ MÀU - Ở Tiệm Bánh Ngày Mai - Múc - AZVietNam', '115.825', '70.000', 'Ở tiệm bánh Ngày Mai - Sắc màu nào tô điểm ngày mai?\r\n“Tại sao lại là tiệm bánh “Ngày Mai” thế?”\r\n“Vì nhìn xem, hôm nay mình đã chuẩn bị gì cho nó đâu nào!”\r\nChuyển mình từ series truyện tranh đời thư', 'tô màu'),
(24, 'https://down-vn.img.susercontent.com/file/sg-11134201-22120-j3f66g7sblkv73', 'SÁCH TÔ MÀU - Ở Tiệm Bánh Ngày Mai - Múc - AZVietNam', '115.825', '70.000', 'Ở tiệm bánh Ngày Mai - Sắc màu nào tô điểm ngày mai?\r\n“Tại sao lại là tiệm bánh “Ngày Mai” thế?”\r\n“Vì nhìn xem, hôm nay mình đã chuẩn bị gì cho nó đâu nào!”\r\nChuyển mình từ series truyện tranh đời thư', 'tô màu'),
(39, 'dc28b71c3578e226bb69.jpg', 'hot facebook', '89.999', '1.200', '&#60;p&#62;hot tiktok&#60;/p&#62;', 'Phim'),
(49, '90023941_769818413885066_8769133624160157696_n.jpg', 'xin chào', '300.000', '20.000', '&#60;p&#62;chán quá đi mất&#60;/p&#62;', 'Sách'),
(50, '184612945_178366660836953_1302141355885118760_n.jpg', 'sssssssssssss', '30.000.000', '290.000', '&#60;p&#62;xin chaog&#60;/p&#62;', 'Sách');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `stars` int(10) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rating`
--

INSERT INTO `rating` (`id`, `product_id`, `stars`, `customer_id`) VALUES
(32, 5, 3, 5),
(33, 5, 1, 5),
(34, 5, 1, 5),
(35, 5, 1, 5),
(36, 5, 1, 5),
(37, 5, 1, 5),
(38, 5, 1, 5),
(39, 5, 1, 5),
(40, 5, 5, 5),
(41, 11, 5, 5),
(42, 13, 5, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `favourite` text DEFAULT NULL,
  `forgotToken` varchar(100) DEFAULT NULL,
  `activeToken` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `password`, `favourite`, `forgotToken`, `activeToken`, `status`, `create_at`, `update_at`, `img`) VALUES
(5, 'Lê Tiến Đạt', 'datthachban12345@gmail.com', '0862515169', '$2y$10$tCYFjcwZzSULZWkNFIRdnecqiuIZH2kGsjD41g2AOJavu10BYu9N6', '6,8,11,5,', NULL, '19790a0a552ad79ed7ceee1752d8904c114ded75', NULL, '2024-04-20 15:54:03', NULL, '88175434_628260187972129_8673522184657829888_n.jpg'),
(6, 'Lê Vinh', 'vinh123@gmail.com', '0862579672', '$2y$10$GeUs9eMst.XtNylW.yLe8.oJo2dqXdIOQ9wCSUyIFezW2.0h6j1SC', NULL, NULL, '834075a505aba828a06faf88047a462d1d720f9a', 0, '2024-03-25 10:42:24', NULL, NULL),
(8, 'Lê Tiến Vinh', 'vinh1234@gmail.com', '0862515169', '$2y$10$3vICSOCOcOl/FZ3hs2iV4O8YjfKjrZGyBeeu8ifXvhcprs2phybpq', NULL, NULL, NULL, 1, '2024-03-09 18:05:48', NULL, NULL),
(10, 'Gao Ồ', 'datthachban12@gmail.com', '0862515169', '$2y$10$WBJ3C1NSnFuatswX1wDCPekyW3zBv/ebzMZ/OdHWeBd0juVV4tKj2', '', NULL, '4a4dca4ba764061d7c12b19ac1eead7019a3419b', 0, '2024-03-24 14:20:33', NULL, NULL),
(11, 'Lê Đạt', 'datthachban@gmail.com', '0862515169', '$2y$10$Yn3Eh6Nl4kqjHsXJaf9tzOfQKSwESLm/YAMorXwdPhgc0Nb5sOhkW', NULL, NULL, '985ea32e5b3f73765c671fc63b3d9f221194810a', 0, '2024-03-28 11:31:46', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `add_category`
--
ALTER TABLE `add_category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `id_user` (`id_user`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `product_Id` (`product_Id`),
  ADD KEY `user_Id` (`user_Id`);

--
-- Chỉ mục cho bảng `logintoken`
--
ALTER TABLE `logintoken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_Id` (`user_Id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `add_category`
--
ALTER TABLE `add_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `logintoken`
--
ALTER TABLE `logintoken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`product_Id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_Id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `logintoken`
--
ALTER TABLE `logintoken`
  ADD CONSTRAINT `logintoken_ibfk_1` FOREIGN KEY (`user_Id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
