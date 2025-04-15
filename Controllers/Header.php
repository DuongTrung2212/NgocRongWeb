<?php
include 'Connections.php';
include 'Session.php';
include 'Configs.php';

if (isset($_FixWeb) && $_FixWeb == 1) {
    echo "Máy chủ đang bảo trì website. Vui lòng chờ nhé!";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>
        <?= $_Title ?>
    </title>
    <link rel="canonical" href="/" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="/" />
    <meta property="og:title" content="<?= $_ServerName ?>" />
    <meta property="og:description" content="<?= $_Description ?>" />
    <meta property="og:image" content="" />
    <link rel="shortcut icon" href="/Assets/Images/titeiteiei.png">
    <meta name="description" content="<?= $_Description ?>">
    <meta name="keywords" content="ngoc rong mobile, game ngoc rong, game 7 vien ngoc rong, game bay vien ngoc rong">
    <link rel="stylesheet" href="/Assets/Css/style.css">
    <link rel="stylesheet" href="/Assets/Css/main.css" />
    <link rel="stylesheet" href="/Assets/Css/bootstrap.min.css">
    <link rel="stylesheet" href="/Assets/Css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body>
    <section class="ant-layout page-layout-color body-bg">
        <main class="ant-layout-content page-body page-layout-color">
            <div class="page-layout-content">
                <div class="ant-row ant-row-space-around">
                    <div class="ant-col page-layout-header ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
                        <div class="page-layout-header-content">
                            <a href="/">
                                <img src="/Assets/Images/<?= $_Logo ?>" class="header-logo"
                                    style="display: block;margin-left: auto;margin-right: auto;max-width: 330px;">
                            </a>
                            <div>
                                <?php
                                if ($_Login === null) {
                                    ?>
                                    <div class="container color-main2 pb-2">
                                        <div class="text-center">
                                            <div class="row">
                                                <div class="col pr-0">
                                                    <a type="button" href="/Auth/Login"
                                                        class="ant-btn ant-btn-default header-btn-login mt-3 me-2">
                                                        <span>Đăng nhập ngay?</span>
                                                    </a>

                                                    <a type="button" href="/Auth/Register"
                                                        class="ant-btn ant-btn-default header-btn-login mt-3">
                                                        <span>Đăng ký</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="container color-main2 pb-2">
                                        <div class="text-center">
                                            <div class="row">
                                                <div class="col pr-0">
                                                    <a type="button" id="userInfoBtn"
                                                        class="ant-btn ant-btn-default header-btn-login mt-3 me-2">
                                                        <span>
                                                            <?= $_Username . ' - ' . formatMoney($_ThoiVang) . ' Thỏi vàng' ?>
                                                        </span>
                                                    </a>
                                                    <a type="button" id="coinsInfoBtn"
                                                        class="ant-btn ant-btn-default header-btn-login me-2">
                                                        <span>
                                                            <?= 'Số Dư: ' . formatMoney($_Coins) . ' | Tổng Nạp: ' . formatMoney($_TCoins) ?>
                                                        </span>
                                                    </a>
                                                    <div class="mt-3">
                                                        <a type="button" href="/Auth/Logout"
                                                            class="ant-btn ant-btn-default header-btn-login">
                                                            <span>Đăng xuất</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
                                    <div class="ant-row ant-row-space-around ant-row-middle header-menu">
                                        <div class="ant-col ant-col-24">
                                            <div class="row ant-space ant-space-horizontal ant-space-align-center space-header-menu d-flex justify-content-center"
                                                style="flex-wrap:wrap;margin-bottom:-10px">
                                                <div class="ant-space-item col-6 col-md-3 col-lg-2"
                                                    style="padding-bottom:10px">
                                                    <div>
                                                        <a href="/Users/Member">
                                                            <button type="button"
                                                                class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                                <b>Mở Thành Viên</b>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ant-space-item col-6 col-md-3 col-lg-2"
                                                    style="padding-bottom:10px">
                                                    <div>
                                                        <a href="/Users/Card">
                                                            <button type="button"
                                                                class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                                <b>Nạp CARD</b>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ant-space-item col-6 col-md-3 col-lg-2"
                                                    style="padding-bottom:10px">
                                                    <div>
                                                        <a href="/Users/Atm">
                                                            <button type="button"
                                                                class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                                <b>Nạp ATM</b>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                              
                                                <div class="ant-space-item col-6 col-md-3 col-lg-2"
                                                    style="padding-bottom:10px">
                                                    <div>
                                                        <a href="/Users/ChangePassword">
                                                            <button type="button"
                                                                class="ant-btn ant-btn-default header-menu-item w-100 /exchange">
                                                                <b>Đổi Mật Khẩu</b>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ant-space-item col-6 col-md-3 col-lg-2"
                                                    style="padding-bottom:10px">
                                                    <div>
                                                        <a href="<?= $_Fanpage ?>">
                                                            <button type="button"
                                                                class="ant-btn ant-btn-default header-menu-item w-100 /fanpage">
                                                                <b>Fanpage</b>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="ant-space-item col-6 col-md-3 col-lg-2"
                                                    style="padding-bottom:10px">
                                                    <div>
                                                        <a href="<?= $_Zalo ?>">
                                                            <button type="button"
                                                                class="ant-btn ant-btn-default header-menu-item w-100 /fanpage">
                                                                <b>BoxZalo SV1</b>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center class="ant-col home_page_bodyTitleList__UdhN_">TẢI NGAY NGỌC RỒNG ORI
						  <div>
						  Đăng kí tài khoản tại web không đăng kí trong game!!!
                        </div>
						</center>
                        <div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
                            <div class="ant-row ant-row-space-around ant-row-middle header-menu">
                                <div class="ant-col ant-col-24">
                                    <div class="row ant-space ant-space-horizontal ant-space-align-center space-header-menu d-flex justify-content-center"
                                        style="flex-wrap:wrap;margin-bottom:-10px">
                                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                            <div>
                                                <a href="/Downloads/Nro.zip">
                                                    <button style="height:45px" type="button"
                                                        class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                        <img src="/Assets/Images/0hrzmer.png" style="width:97px" />
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
								
                                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                            <div>
                                                <a href="/Downloads/Nro.apk">
                                                    <button style="height:45px" type="button"
                                                        class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                        <img src="/Assets/Images/RAGk2Dn.png" style="width:97px" />
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                            <div>
                                                <a href="https://testflight.apple.com/join/5YJ489eN">
                                                    <button style="height:45px" type="button"
                                                        class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                        <img src="/Assets/Images/XnpBrRa.png" style="width:97px" />
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>