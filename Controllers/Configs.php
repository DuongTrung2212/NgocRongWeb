<?php
#NGUYEN TRA GIA BAO - Ngoc Rong ORI

$_Logo = 'Logo.png'; // Thay tên + đuôi của Logo vào đây
$_Title = 'Ngọc Rồng ORI | Máy Chủ Ngọc Rồng Online';
$_ServerName = 'Ngọc Rồng ORI';
$_Description = 'Website chính thức của Ngọc Rồng ORI – Game Bay Vien Ngoc Rong Mobile nhập vai trực tuyến trên máy tính và điện thoại về Game 7 Viên Ngọc Rồng hấp dẫn nhất hiện nay!';
$_ForgotEmail = 'Email'; // Gmail Chạy Quên Mật Khẩu
$_ForgotPass = 'Password'; // Mật Khẩu Gmail Chạy Quên Mật Khẩu
$_GiaTri = '1'; // Nạp x1 -> x2 -> x3 (Thẻ Cào)
$_GiaTriAtm = '1'; // Chuyển Khoản x1 -> x2 -> x3
$_TrangThai = '1'; // Hoạt Động = 1, Bảo Trì = 0 (Trạng Thái Nạp Tiền)
$_AutoMember = '0'; // Auto mở khi nạp = 1, Tắt Auto mở thành viên = 0 (Áp dạng cho nạp thẻ và Atm)
$_FixWeb = '0'; // Bảo Trì = 1, Không Bảo Trì = 0
$_AuthLog = '0'; // Bảo Trì = 1, Không Bảo Trì = 0

#Hỗ Trợ
$_Fanpage = '';
$_Zalo = 'https://zalo.me/g/jlflos982';


#---------------#
#Downloads
$_Android = '/Downloads/DucKien.apk'; // Downloads nơi lưu file game
$_Iphone = '/Downloads/DucKien.ipa';
$_Java = '/Downloads/DucKien.jar';
$_Windows = '/Downloads/DucKien.rar';

#Card
$Partner_Key = 'b849b8b628fbfdb2c5666145738017e9';
$Partner_Id = '79992479357';
$_ApiCard = 'https://gachthe123.com/'; // Link Đại Lý Thẻ

#Atm - Mbbank
$UserMB = 'hoanganhbx123';
$PassMB = 'Phaithatgiau123@A';
$StkMB = '0000807748070';
$NameMB = 'BUI HOANG ANH';
function CreateToken()
{
    return md5(uniqid(rand(), true));
}