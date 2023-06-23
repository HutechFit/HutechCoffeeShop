<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kết quả thanh toán</title>
</head>
<body class="main-layout inner_page">
<?php include_once 'Views/Partials/Header.php'; ?>
<?php if (empty($vnp_SecureHash)) : ?>
    <div class="d-flex align-items-center justify-content-center vh-25 service"
         style="background: #FFFFFF">
        <div class="text-center">
            <h1 class="display-1 fw-bold text-info">Không tồn tại</h1><br>
            <p class="fs-3"><span class="text-danger">Opps!</span> Hoá đơn không tồn tại.</p>
            <p class="lead">
                Hãy thử lại.
            </p> <br>
            <a href="/hutech-coffee/order" class="read_more">Mua hàng</a>
        </div>
    </div>
<?php else : ?>
    <section class="vh-100" style="background-color: #f4f5f7;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                    <div class="card mb-3" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white"
                                 style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <?php if ($secureHash !== $vnp_SecureHash) : ?>
                                    <img src="https://www.svgrepo.com/show/444337/gui-check-no.svg"
                                         alt="FAIL"
                                         class="img-fluid my-5"
                                         style="width: 80px;"/>
                                    <h6 class="text-danger text-center">Chữ ký không hợp lệ</h6>
                                    <a href="/" class="btn btn-outline-danger mt-4">Trang chủ</a>
                                <?php else : ?>
                                    <?php if ($vnp_ResponseCode !== '00') : ?>
                                        <img src="https://www.svgrepo.com/show/444337/gui-check-no.svg"
                                             alt="FAIL"
                                             class="img-fluid my-5"
                                             style="width: 80px;"/>
                                        <h6 class="text-danger text-center">Thanh toán thất bại</h6>
                                        <a href="/" class="btn btn-outline-danger mt-4">Trang chủ</a>
                                    <?php else : ?>
                                        <img src="https://www.svgrepo.com/show/384403/accept-check-good-mark-ok-tick.svg"
                                             alt="OK"
                                             class="img-fluid my-5"
                                             style="width: 80px;"/>
                                        <h6 class="text-success text-center">Thanh toán thành công</h6>
                                        <a href="/" class="btn btn-outline-success mt-4">Trang chủ</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <p>Thông tin thanh toán</p>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6 class="text-dark">Mã đơn hàng</h6>
                                            <p class="text-muted"><?= $_GET['vnp_TxnRef'] ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6 class="text-dark">Nội dung</h6>
                                            <p class="text-muted"><?= $_GET['vnp_OrderInfo'] ?></p>
                                        </div>
                                    </div>
                                    <p>Kết quả thanh toán</p>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6 class="text-dark">Thời gian thanh toán</h6>
                                            <p class="text-muted"><?= date('d/m/Y', strtotime($_GET['vnp_PayDate'])) ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6 class="text-dark">Số tiền</h6>
                                            <p class="text-muted">
                                                <?= numfmt_format_currency(
                                                    numfmt_create('vi_VN', NumberFormatter::CURRENCY),
                                                    $_GET['vnp_Amount'] / 100, 'VND'
                                                ) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php include_once 'Views/Partials/Footer.php'; ?>
</body>
</html>