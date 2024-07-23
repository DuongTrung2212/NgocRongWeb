<?php
include '../../Controllers/Header.php';
if ($_Login === null) {
    echo '<script>window.location.href = "/Auth/Login";</script>';
}
?>
<div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
    <div class="page-layout-body">
        <div class="ant-col ant-col-24">
            <div class="card-header">
                <div class="container pt-5 pb-5">
                    <e class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <h4 style="display: inline-block; margin-right: 10px;">CHUYỂN KHOẢN | QRPAY</h4>
                            <center>
                                <img class="mb-3"
                                    src="https://img.vietqr.io/image/MB-<?= $StkMB ?>-qr_only.png?&addInfo=naptien<?= $_Id ?>&accountName=<?= $NameMB ?>"
                                    width="200px" height="200px">
                            </center>
                        </div>
                        <?php if ($_TrangThai == 0) { ?>
                            <center><b>Nạp Tiền Đang Bảo trì, Nạp trong thời gian này sẽ không được hỗ trợ</b></center>
                            <br>
                            <br>
                        <?php } else { ?>
                            <center>
                                - Tự động duyệt sau 1-2 phút, nếu chưa duyệt hãy liên hệ cho admin ngay nhé!
                                <br>
                                - Chỉ duyệt những giao dịch trên 3,000 VNĐ
                                <?php if ($_AutoMember == 1) { ?>
                                    <br>
                                    <p>- Máy chủ đang bật tính năng tự động mở thành viên khi nạp mệnh giá 20,000 VNĐ
                                    </p>
                                    <br>
                                <?php } ?>
                            </center>
                        <?php } ?>
                        <ul class="list-group mb-2">
                            <li class="list-group-item">Số tài khoản: <b style="color: green;">
                                    <?= $StkMB ?>
                                </b>
                            </li>
                            <li class="list-group-item">Chủ tài khoản: <b>
                                    <?= $NameMB ?>
                                </b>
                            </li>
                            <li class="list-group-item">Ngân hàng: <b>
                                    MBBank
                                </b></li>
                            <li class="list-group-item">Nội dung:
                                <b>
                                    <?php if ($_TrangThai == 0) { ?>
                                        Bảo trì
                                    <?php } else { ?>
                                        naptien<?= $_Id; ?>
                                    <?php } ?>
                                </b>

                            </li>
                        </ul>
                        <center>
                            <i class="fa fa-spinner fa-spin"></i> Xử lý giao dịch tự động trong vài phút...</i>
                        </center>
                        <hr>
                        <div class="table-responsive">
                            <div style="line-height: 15px;font-size: 12px;padding-right: 5px;margin-bottom: 8px;padding-top: 2px;"
                                class="text-center">
                                <p><i>Chân Thành Cảm Ơn Vì Đã Ủng Hộ Chúng Tôi.</i></p>

                                <tbody style="border-color: black;">
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include '../../Controllers/Footer.php';
?>