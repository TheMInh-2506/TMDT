-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 22, 2021 lúc 01:00 PM
-- Phiên bản máy phục vụ: 5.7.36-0ubuntu0.18.04.1
-- Phiên bản PHP: 7.2.34-26+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `cuahangnoithat`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ct_hoadon`
--

CREATE TABLE `ct_hoadon` (
  `MAHD` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `MASP` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `SOLUONG` int(200) NOT NULL,
  `GIA` int(11) NOT NULL,
  `PHANTRAMGIAM` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ct_hoadon`
--

INSERT INTO `ct_hoadon` (`MAHD`, `MASP`, `SOLUONG`, `GIA`, `PHANTRAMGIAM`) VALUES
('HD01', 'SP01', 3, 120000, 5),
('HD01', 'SP05', 2, 80000, 5),
('HD02', 'SP05', 1, 80000, 5),
('HD03', 'SP05', 2, 80000, 5),
('HD04', 'SP03', 1, 5302000, 4),
('HD04', 'SP30', 1, 355000, 0),
('HD04', 'SP53', 1, 155000, 0),
('HD05', 'SP29', 1, 255000, 0),
('HD05', 'SP30', 1, 355000, 0),
('HD06', 'SP29', 1, 255000, 0),
('HD06', 'SP30', 1, 355000, 0),
('HD07', 'SP08', 1, 15000, 2),
('HD08', 'SP08', 1, 15000, 2),
('HD09', 'SP05', 1, 80000, 5),
('HD10', 'SP40', 1, 35000, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ct_phieunhap`
--

CREATE TABLE `ct_phieunhap` (
  `MAPN` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `MASP` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `SOLUONG` int(200) NOT NULL,
  `GIA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ct_phieunhap`
--

INSERT INTO `ct_phieunhap` (`MAPN`, `MASP`, `SOLUONG`, `GIA`) VALUES
('PN01', 'SP01', 20, 120000),
('PN01', 'SP25', 14, 87000),
('PN02', 'SP02', 20, 250000),
('PN03', 'SP20', 50, 157000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `MAHD` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `MANV` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MAKH` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `NGAYLAP` date NOT NULL,
  `GIOLAP` time NOT NULL,
  `TONG` int(11) NOT NULL,
  `MATRANGTHAI` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `MAKM` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `PAYPAL` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`MAHD`, `MANV`, `MAKH`, `NGAYLAP`, `GIOLAP`, `TONG`, `MATRANGTHAI`, `MAKM`, `PAYPAL`) VALUES
('HD01', 'NV00', 'KH01', '2021-01-11', '21:52:29', 520000, 'TT03', 'KM02', 0),
('HD02', 'NV00', 'KH02', '2021-02-11', '22:04:35', 76000, 'TT01', 'KM00', 1),
('HD03', NULL, 'KH03', '2021-03-11', '22:06:45', 160000, 'TT04', 'KM02', 0),
('HD04', NULL, 'KH04', '2021-04-14', '20:48:49', 5812000, 'TT01', 'KM02', 0),
('HD05', NULL, 'KH05', '2021-05-14', '20:58:29', 610000, 'TT01', 'KM02', 0),
('HD06', NULL, 'KH06', '2021-07-14', '21:03:00', 610000, 'TT01', 'KM02', 0),
('HD07', NULL, 'KH01', '2021-10-14', '21:04:51', 15000, 'TT01', 'KM02', 0),
('HD08', NULL, 'KH02', '2021-11-14', '21:06:01', 15000, 'TT01', 'KM02', 0),
('HD09', NULL, 'KH03', '2021-12-18', '09:29:19', 80000, 'TT01', 'KM03', 0),
('HD10', NULL, 'KH01', '2021-12-22', '11:06:23', 35000, 'TT01', 'KM03', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MAKH` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `TENKH` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `NGAYSINH` date DEFAULT NULL,
  `GIOITINH` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `TENDN` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `MATKHAU` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `DIACHI` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `SDT` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `TRANGTHAI` tinyint(1) NOT NULL,
  `DIEMTL` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MAKH`, `TENKH`, `NGAYSINH`, `GIOITINH`, `TENDN`, `MATKHAU`, `DIACHI`, `SDT`, `TRANGTHAI`, `DIEMTL`) VALUES
('KH01', 'Phạm Nguyễn Minh Thuận', '2001-01-28', 'Nam', 'thuan@gmail.com', '202cb962ac59075b964b07152d234b70', 'Bến Tre,Việt Nam', '0123456789', 1, 0),
('KH02', 'Nguyễn Thị Hoa', '2001-01-01', 'Nữ', 'hoa@gmail.com', '202cb962ac59075b964b07152d234b70', 'Hà Tĩnh', '0123456789', 1, 0),
('KH03', 'Lý Thế Minh', '2001-01-01', 'Nam', 'minh@gmail.com', '202cb962ac59075b964b07152d234b70', 'Sóc Trăng', '0123456789', 0, 0),
('KH04', 'Đỗ Nhỉ Khang', '2001-01-28', 'Nam', 'khang@gmail.com', '202cb962ac59075b964b07152d234b70', 'TPHCM', '0123456789', 1, 0),
('KH05', 'Phạm Thị Ngọc Huyền', '2001-01-01', 'Nữ', 'huyen@gmail.com', '202cb962ac59075b964b07152d234b70', 'Bến Tre', '0123456789', 1, 0),
('KH06', 'Nguyễn Thị Thanh Thúy', '2001-01-01', 'Nữ', 'thuy@gmail.com', '202cb962ac59075b964b07152d234b70', 'Long An', '0123456789', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `MAKM` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `NGAYBD` date NOT NULL,
  `NGAYKT` date NOT NULL,
  `PHANTRAMGIAM` int(10) NOT NULL,
  `TRANGTHAI` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khuyenmai`
--

INSERT INTO `khuyenmai` (`MAKM`, `NGAYBD`, `NGAYKT`, `PHANTRAMGIAM`, `TRANGTHAI`) VALUES
('KM00', '1000-12-01', '3021-12-31', 0, 0),
('KM01', '2021-10-03', '2021-10-21', 5, 1),
('KM02', '2021-11-01', '2022-11-30', 16, 1),
('KM03', '2021-12-01', '2021-12-30', 5, 1),
('KM04', '2021-12-20', '2021-12-25', 3, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `MALOAI` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `TENLOAI` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `MOTA` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`MALOAI`, `TENLOAI`, `MOTA`) VALUES
('LSP01', 'Trang trí', 'Các phụ kiện nhập khẩu từ các hãng thiết kế nội thất uy tín của Australia mang lại điểm nhấn đặc biệt sang trọng cho không gian nội thất'),
('LSP02', 'Phòng Ngủ', 'Các sản phẩm giường ngủ da thật của MILD được bọc bằng chất liệu da bò Ý mềm mại, cao cấp với khung sườn của sản phẩm sử dụng vật liệu thân thiện với môi trường, được chế tạo cẩn thận nhằm đảm bảo chất lượng và tuổi thọ. Với thiết kế độc đáo và đẳng cấp, giường ngủ da thật của MILD mang lại sự thoải mái tuyệt đối trong không gian đẳng cấp.'),
('LSP03', 'Phòng Làm Việc', 'Các sản phẩm dành cho phòng làm việc của MILD được bọc bằng chất liệu ao cấp với khung sườn của sản phẩm sử dụng vật liệu thân thiện với môi trường, được chế tạo cẩn thận nhằm đảm bảo chất lượng và tuổi thọ. Với thiết kế độc đáo và đẳng cấp.'),
('LSP04', 'Phòng Khách', 'Nét hiện đại cho căn hộ là lựa chọn thông minh cho phòng khách sang trọng, tiện nghi và đẳng cấp. Được thiết kế có tính năng độc đáo, tiện lợi, chắc chắn sẽ đem đến những phút giây thư giãn tuyệt vời mỗi khi trở về nhà.'),
('LSP05', 'Phòng Ăn ', 'Mỗi khoảnh khắc quây quần bên bàn ăn luôn là những phút giây đầm ấm tuyệt đẹp. Với chất liệu mẫu mã đa dạng cùng thiết kế độc đáo, từng sản phẩm của Cozy hướng tới kiến tạo không gian sang trọng nhưng cũng vô cùng đầm ấm và tinh tế.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `MANCC` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `TENNCC` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `DIACHI` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `SDT` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `TRANGTHAI` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`MANCC`, `TENNCC`, `DIACHI`, `SDT`, `TRANGTHAI`) VALUES
('NCC01', 'Nhà Cung Cấp TPHCM', 'TPHCM', '0843739379', 1),
('NCC02', 'Nhà Cung Cấp Tiền Giang', 'Tiền Giang ', '0978456123', 0),
('NCC03', 'Nhà Cung Cấp Bến Tre', 'Bến Tre', '0843739379', 1),
('NCC04', 'Nhà Cung Cấp Kiên Giang', 'Kiên Giang ', '0843739379', 1),
('NCC05', 'Nhà Cung Cấp Hà Nội ', 'TP HCM', '0843455652', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MANV` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `TENNV` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `NGAYSINH` date NOT NULL,
  `GIOITINH` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `DIACHI` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `SDT` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `MAQUYEN` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `TENDN` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `MATKHAU` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TRANGTHAI` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MANV`, `TENNV`, `NGAYSINH`, `GIOITINH`, `DIACHI`, `SDT`, `MAQUYEN`, `TENDN`, `MATKHAU`, `TRANGTHAI`) VALUES
('NV00', 'Quản trị viên', '2000-01-01', 'Nam', 'TP.HCM', '088123456', '1', 'root', '202cb962ac59075b964b07152d234b70', 1),
('NV01', 'Trần Văn B', '2021-10-04', 'Nam', 'Tiền Giang', '0974158320', '2', 'nhanvien1', '202cb962ac59075b964b07152d234b70', 0),
('NV02', 'Nguyễn Thị C', '2001-01-28', 'Nam', 'Bến Tre', '0843739379', '2', 'nhanvien2', '202cb962ac59075b964b07152d234b70', 1),
('NV03', 'Phạm Văn D', '2021-11-16', 'Nam', 'Long ANh', '0843739379', '2', 'nhanvien3', '202cb962ac59075b964b07152d234b70', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `noithat`
--

CREATE TABLE `noithat` (
  `MASP` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `TENSP` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `MALOAI` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `GIA` int(11) NOT NULL,
  `SOLUONG` int(200) NOT NULL,
  `HINHANH` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TRANGTHAI` tinyint(1) NOT NULL,
  `PHANTRAMGIAM` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `noithat`
--

INSERT INTO `noithat` (`MASP`, `TENSP`, `MALOAI`, `GIA`, `SOLUONG`, `HINHANH`, `TRANGTHAI`, `PHANTRAMGIAM`) VALUES
('SP01', 'Bàn ăn 6 người', 'LSP05', 120000, 2, 'ban_an_6_nguoi.jpg', 1, 0),
('SP02', 'Bàn phòng khách', 'LSP04', 250000, 90, 'ban.jpg', 0, 0),
('SP03', 'Bàn ghế bệt', 'LSP03', 5302000, 140, 'banghebet.jpg', 1, 0),
('SP04', 'Bàn trang điểm', 'LSP02', 50000, 120, 'bantrangdiem1.jpg', 1, 0),
('SP05', 'Bộ 5 khung tranh treo tường', 'LSP01', 80000, 22, '5khungtranhtreotuong.jpg', 1, 5),
('SP07', 'Bộ 11 khung tranh treo tường', 'LSP01', 80000, 34, '11khungtranhtreotuong.jpg', 1, 0),
('SP08', 'Đèn đọc sách', 'LSP01', 15000, 2, 'den.png', 1, 2),
('SP09', 'Đèn thả trần trang trí', 'LSP01', 45000, 80, 'den1.jpg', 1, 0),
('SP10', 'Đồng hồ Shouse', 'LSP01', 115000, 35, 'dongho1.jpg', 1, 0),
('SP11', 'Đồng hồ treo tường', 'LSP01', 20000, 35, 'dongho.png', 1, 0),
('SP12', 'Ghế xích đu', 'LSP01', 555000, 5, 'ghexichdu.jpg', 1, 0),
('SP13', 'Gương treo tường', 'LSP01', 5000, 35, 'guong.jpg', 1, 0),
('SP14', 'Thảm phòng khách loại 1', 'LSP01', 30000, 35, 'tham.jpg', 1, 0),
('SP15', 'Thảm phòng khách loại 2', 'LSP01', 25000, 35, 'tham1.jpg', 1, 0),
('SP16', 'Thảm phòng khách loại 3', 'LSP01', 35000, 35, 'tham2.jpg', 1, 0),
('SP17', 'Thảm phòng khách loại 4', 'LSP01', 52000, 35, 'tham3.jpg', 1, 0),
('SP18', 'Xích đu hình bán cầu giọt nước', 'LSP01', 999000, 35, 'xichdubancau.jpg', 1, 0),
('SP19', 'Bàn trang điểm phòng ngủ loại 1', 'LSP02', 147000, 35, 'bantrangdiem.jpg', 1, 0),
('SP20', 'Bàn trang điểm phòng ngủ loại 2', 'LSP02', 157000, 85, 'bantrangdiem1.jpg', 1, 0),
('SP21', 'Giường ngủ loại 1', 'LSP02', 2530650, 35, 'giuong.jpg', 1, 0),
('SP22', 'Giường ngủ loại 2', 'LSP02', 2750000, 34, 'giuong1.jpg', 1, 0),
('SP23', 'Giường ngủ loại 3', 'LSP02', 3000000, 35, 'giuong2.jpg', 1, 0),
('SP24', 'Tủ đầu giường loại 1', 'LSP02', 88000, 35, 'tudaugiuong.jpg', 1, 0),
('SP25', 'Tủ đầu giường loại 2', 'LSP02', 87000, 10, 'tudaugiuong1.jpg', 1, 0),
('SP26', 'Tủ quần áo loại 1', 'LSP02', 450000, 35, 'tuquanao.jpg', 1, 0),
('SP27', 'Tủ quần áo loại 2', 'LSP02', 430000, 35, 'tuquanao1.jpg', 1, 0),
('SP28', 'Tủ quần áo loại 3', 'LSP02', 560000, 35, 'tuquanao2.jpg', 1, 0),
('SP29', 'Bàn làm việc loại 1', 'LSP03', 255000, 5, 'banlamviec.png', 1, 0),
('SP30', 'Bàn làm việc loại 2', 'LSP03', 355000, 20, 'banlamviec1.jpg', 1, 0),
('SP31', 'Bàn làm việc loại 3', 'LSP03', 455000, 15, 'banlamviec2.png', 1, 0),
('SP32', 'Ghế văn phòng loại 1', 'LSP03', 253000, 6, 'ghevanphong.jpg', 1, 0),
('SP33', 'Ghế văn phòng loại 2', 'LSP03', 551000, 12, 'ghevanphong1.jpeg', 1, 0),
('SP34', 'Ghế văn phòng loại 3', 'LSP03', 525000, 75, 'ghevanphong2.png', 1, 0),
('SP35', 'Tủ kệ sách loại 1', 'LSP03', 30000, 35, 'tukesach1.jpg', 1, 0),
('SP36', 'Tủ kệ sách loại 2', 'LSP03', 52000, 25, 'tukesach2.jpg', 1, 0),
('SP37', 'Tủ kệ sách loại 3', 'LSP03', 99000, 15, 'tukesach3.jpg', 1, 0),
('SP39', 'Bàn ghế loại 1', 'LSP04', 55000, 2, 'banghe1.jpg', 1, 0),
('SP40', 'Bàn ghế loại 2', 'LSP04', 35000, 3, 'banghe2.jpg', 1, 0),
('SP41', 'Bàn loại 1', 'LSP04', 655000, 15, 'ban1.jpg', 1, 0),
('SP42', 'Bàn loại 2', 'LSP04', 553000, 6, 'ban2.jpg', 1, 0),
('SP43', 'Bàn loại 3', 'LSP04', 555000, 12, 'ban3.jpg', 1, 0),
('SP44', 'Sofa loại 1', 'LSP04', 225000, 75, 'sofa.jpg', 1, 0),
('SP45', 'Sofa loại 2', 'LSP04', 300000, 35, 'sofa1.jpg', 1, 0),
('SP46', 'Sofa loại 3', 'LSP04', 520000, 25, 'sofa2.jpg', 1, 0),
('SP47', 'Tủ giày dép loại 1', 'LSP04', 82000, 15, 'tugiaydep1.jpg', 1, 0),
('SP48', 'Tủ giày dép loại 2', 'LSP04', 90000, 15, 'tugiaydep2.jpg', 1, 0),
('SP49', 'Tủ tivi loại 1', 'LSP04', 919000, 15, 'tutivi1.jpg', 1, 0),
('SP50', 'Tủ tivi loại 2', 'LSP04', 829000, 15, 'tutivi2.png', 1, 0),
('SP51', 'Tủ tivi loại 3', 'LSP04', 889000, 15, 'tutivi3.jpg', 1, 0),
('SP52', 'Tủ trưng bày', 'LSP04', 99000, 15, 'tutrungbay.jpg', 1, 0),
('SP53', 'Bộ bàn ăn gỗ', 'LSP05', 155000, 6, 'bobanangho.jpg', 1, 0),
('SP54', 'Bộ bàn ăn hiện đại', 'LSP05', 135000, 2, 'bobananhiendai.jpg', 1, 0),
('SP55', 'Tủ bếp cao cấp', 'LSP05', 655000, 15, 'tubepcaocap.jpg', 1, 0),
('SP56', 'Tủ bếp chữ I', 'LSP05', 553000, 6, 'tubepchu_i.jpg', 1, 0),
('SP57', 'Tủ bếp gỗ chữ L', 'LSP05', 855000, 1, 'tubepgochu_l.jpg', 1, 0),
('SP58', 'Tủ trữ đồ nhà bếp', 'LSP05', 75000, 5, 'tutrudonhabep.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieunhap`
--

CREATE TABLE `phieunhap` (
  `MAPN` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `MANV` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `MANCC` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `NGAYLAP` date NOT NULL,
  `GIOLAP` time NOT NULL,
  `TONG` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phieunhap`
--

INSERT INTO `phieunhap` (`MAPN`, `MANV`, `MANCC`, `NGAYLAP`, `GIOLAP`, `TONG`) VALUES
('PN01', 'NV00', 'NCC02', '2021-12-15', '11:25:20', 3618000),
('PN02', 'NV01', 'NCC03', '2021-12-15', '11:30:57', 5000000),
('PN03', 'NV02', 'NCC01', '2021-12-18', '03:00:59', 8379000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quyen`
--

CREATE TABLE `quyen` (
  `MAQUYEN` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `TENQUYEN` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `MOTA` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quyen`
--

INSERT INTO `quyen` (`MAQUYEN`, `TENQUYEN`, `MOTA`) VALUES
('1', 'Admin', 'Nhân viên Admin'),
('2', 'Bán Hàng', 'Nhân viên bán hàng ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthaidonhang`
--

CREATE TABLE `trangthaidonhang` (
  `MATRANGTHAI` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `MOTATRANGTHAI` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthaidonhang`
--

INSERT INTO `trangthaidonhang` (`MATRANGTHAI`, `MOTATRANGTHAI`) VALUES
('TT05', 'Admin hủy hóa đơn'),
('TT01', 'Chờ Xác Nhận'),
('TT03', 'Đã nhận'),
('TT02', 'Đã xác nhận'),
('TT04', 'Khách Hàng hủy hóa đơn');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `ct_hoadon`
--
ALTER TABLE `ct_hoadon`
  ADD PRIMARY KEY (`MAHD`,`MASP`),
  ADD KEY `MASP` (`MASP`);

--
-- Chỉ mục cho bảng `ct_phieunhap`
--
ALTER TABLE `ct_phieunhap`
  ADD PRIMARY KEY (`MAPN`,`MASP`),
  ADD KEY `MASP` (`MASP`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MAHD`),
  ADD KEY `MANV` (`MANV`,`MAKH`,`MATRANGTHAI`),
  ADD KEY `MATRANGTHAI` (`MATRANGTHAI`),
  ADD KEY `hoadon_ibfk_6` (`MAKH`),
  ADD KEY `MAKHUYENMAI` (`MAKM`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MAKH`),
  ADD UNIQUE KEY `TENDN` (`TENDN`),
  ADD KEY `MATKHAU` (`MATKHAU`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`MAKM`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`MALOAI`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MANCC`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MANV`),
  ADD UNIQUE KEY `TENDN` (`TENDN`),
  ADD KEY `MATKHAU` (`MATKHAU`),
  ADD KEY `MAQUYEN` (`MAQUYEN`);

--
-- Chỉ mục cho bảng `noithat`
--
ALTER TABLE `noithat`
  ADD PRIMARY KEY (`MASP`),
  ADD KEY `MALOAI` (`MALOAI`);

--
-- Chỉ mục cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD PRIMARY KEY (`MAPN`),
  ADD KEY `MANCC` (`MANCC`),
  ADD KEY `MANV` (`MANV`);

--
-- Chỉ mục cho bảng `quyen`
--
ALTER TABLE `quyen`
  ADD PRIMARY KEY (`MAQUYEN`);

--
-- Chỉ mục cho bảng `trangthaidonhang`
--
ALTER TABLE `trangthaidonhang`
  ADD PRIMARY KEY (`MATRANGTHAI`),
  ADD KEY `MOTATRANGTHAI` (`MOTATRANGTHAI`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `ct_hoadon`
--
ALTER TABLE `ct_hoadon`
  ADD CONSTRAINT `ct_hoadon_ibfk_2` FOREIGN KEY (`MAHD`) REFERENCES `hoadon` (`MAHD`),
  ADD CONSTRAINT `ct_hoadon_ibfk_3` FOREIGN KEY (`MASP`) REFERENCES `noithat` (`MASP`);

--
-- Các ràng buộc cho bảng `ct_phieunhap`
--
ALTER TABLE `ct_phieunhap`
  ADD CONSTRAINT `ct_phieunhap_ibfk_1` FOREIGN KEY (`MAPN`) REFERENCES `phieunhap` (`MAPN`),
  ADD CONSTRAINT `ct_phieunhap_ibfk_2` FOREIGN KEY (`MASP`) REFERENCES `noithat` (`MASP`);

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`MATRANGTHAI`) REFERENCES `trangthaidonhang` (`MATRANGTHAI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hoadon_ibfk_5` FOREIGN KEY (`MANV`) REFERENCES `nhanvien` (`MANV`),
  ADD CONSTRAINT `hoadon_ibfk_6` FOREIGN KEY (`MAKH`) REFERENCES `khachhang` (`MAKH`),
  ADD CONSTRAINT `hoadon_ibfk_7` FOREIGN KEY (`MAKM`) REFERENCES `khuyenmai` (`MAKM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`MAQUYEN`) REFERENCES `quyen` (`MAQUYEN`);

--
-- Các ràng buộc cho bảng `noithat`
--
ALTER TABLE `noithat`
  ADD CONSTRAINT `noithat_ibfk_3` FOREIGN KEY (`MALOAI`) REFERENCES `loaisanpham` (`MALOAI`);

--
-- Các ràng buộc cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD CONSTRAINT `phieunhap_ibfk_1` FOREIGN KEY (`MANV`) REFERENCES `nhanvien` (`MANV`),
  ADD CONSTRAINT `phieunhap_ibfk_2` FOREIGN KEY (`MANCC`) REFERENCES `nhacungcap` (`MANCC`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;