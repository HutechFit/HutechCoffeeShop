<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          crossorigin="anonymous"
          referrerpolicy="no-referrer"/>
    <title>Giỏ hàng</title>
</head>
<body class="main-layout inner_page">
<?php include_once 'Views/Partials/Header.php'; ?>
<?php if (empty($cart)) : ?>
    <div class="d-flex align-items-center justify-content-center vh-25">
        <div class="text-center">
            <h1 class="display-1 fw-bold text-info">Chưa có món nào</h1><br>
            <p class="fs-3"><span class="text-danger">Opps!</span> Giỏ hàng của bạn đang trống.</p>
            <p class="lead">
                Vui đặt món để thưởng thức những ly cà phê thơm ngon.
            </p> <br>
            <a href="/hutech-coffee/order"
               class="read_more">Đặt món</a>
        </div>
    </div>
<?php else : ?>
    <section class="h-100 gradient-custom">
        <div class="container py-5">
            <div class="row d-flex justify-content-center my-4">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0 text-dark">Giỏ hàng: <?= count($cart) ?> sản phẩm</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($cart as $item): ?>
                                <div class="row">
                                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                        <div class="bg-image hover-overlay hover-zoom ripple rounded"
                                             data-mdb-ripple-color="light">
                                            <img src="<?= $item['image'] ?>"
                                                 alt="<?= $item['name'] ?>"
                                                 class="w-100"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                        <p><strong><?= $item['name'] ?></strong></p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                        <div class=" mb-4" style="max-width: 300px">
                                            <div class="form-outline">
                                                <input id="form1"
                                                       min="1"
                                                       step="1"
                                                       max="100"
                                                       type="number"
                                                       value="<?= $item['quantity'] ?>"
                                                       data-id="<?= $item['id'] ?>"
                                                       class="form-control quantity-input"/>
                                                <label class="form-label"
                                                       for="form1">Số lượng</label>
                                            </div>
                                            <button id="remove-item"
                                                    class="btn btn-danger btn-sm me-1 mb-2"
                                                    type="button"
                                                    data-id="<?= $item['id'] ?>"
                                                    data-mdb-toggle="tooltip"
                                                    title="Xoá sản phẩm">
                                                <i class="fas fa-trash" style="color: white"></i>
                                            </>
                                        </div>

                                        <p class="text-start text-md-center">
                                            <strong><?= numfmt_format_currency(numfmt_create('vi_VN', NumberFormatter::CURRENCY), $item['price'] * $item['quantity'], 'VND') ?></strong>
                                        </p>
                                    </div>
                                </div>
                                <?php if ($item !== end($cart)): ?>
                                    <hr class="my-4"/>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-body flex-row align-content-center">
                                <div class="form-outline flex-fill">
                                    <input type="text"
                                           id="form1"
                                           name="discount"
                                           class="form-control form-control-lg"
                                           placeholder="Nhập mã giảm giá"/>
                                    <label class="form-label"
                                           for="form1"></label>
                                    <?php if (isset($_SESSION['discount'])): ?>
                                        <div class="alert alert-success alert-dismissible fade show"
                                             role="alert">
                                            <strong>Đã áp dụng mã giảm giá!</strong> <?= $_SESSION['discount']['name'] ?>
                                            <button type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="alert"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php elseif (isset($_SESSION['discount_error'])): ?>
                                        <div class="alert alert-danger alert-dismissible fade show"
                                             role="alert">
                                            <strong><?= $_SESSION['discount_error'] ?></strong>
                                            <button type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <button type="button"
                                        class="btn btn-outline-warning btn-lg ms-3">Áp dụng
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body">
                            <p><strong>Chúng tôi chấp nhận:</strong></p>
                            <img width="45px"
                                 src="https://vnpay.vn/assets/images/logo-icon/logo-primary.svg"
                                 alt="Vnpay"/>
                            <img width="45px"
                                 src="https://asset.brandfetch.io/idxAg10C0L/idATb3amIw.svg"
                                 alt="Striped"/>
                            <img width="45px"
                                 src="https://developers.momo.vn/v3/vi/assets/images/logo-custom2-57d6118fe524633b89befe8cb63a3956.png"
                                 alt="Momo"/>
                            <img width="45px"
                                 src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png"
                                 alt="PayPal"/>
                            <img width="45px"
                                 src="https://www.svgrepo.com/show/362033/visa.svg"
                                 alt="Visa"/>
                            <img width="45px"
                                 src="https://www.svgrepo.com/show/508701/mastercard-full.svg"
                                 alt="MasterCard"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0 text-dark">Tổng tiền</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Sản phẩm
                                    <span>
                                        <?= numfmt_format_currency(
                                            numfmt_create('vi_VN', NumberFormatter::CURRENCY),
                                            array_sum(
                                                array_map(function ($item) {
                                                    return $item['price'] * $item['quantity'];
                                                }, $cart)
                                            ),
                                            'VND'
                                        ) ?>
                                </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Tổng số tiền</strong>
                                        <strong>
                                            <p class="mb-0">(đã bao gồm 5% VAT)</p>
                                        </strong>
                                    </div>
                                    <span>
                                        <?= numfmt_format_currency(
                                            numfmt_create('vi_VN', NumberFormatter::CURRENCY),
                                            ceil(
                                                array_sum(
                                                    array_map(function ($item) {
                                                        return $item['price'] * $item['quantity'] * 1.05;
                                                    }, $cart)
                                                ) / 1000
                                            ) * 1000,
                                            'VND'
                                        ) ?>
                                    </span>
                                </li>
                            </ul>

                            <button type="button"
                                    id="checkout"
                                    class="btn btn-outline-info btn-lg btn-block">
                                Tiến hành thanh toán
                            </button>

                            <button type="button"
                                    id="clear-cart"
                                    class="btn btn-outline-danger btn-lg btn-block mt-3">
                                Xóa giỏ hàng
                            </button>
                            <hr>
                            <div class="text-center">
                                <a href="/hutech-coffee/order"
                                   class="text-primary mt-3">
                                    <i class="fas fa-arrow-left"></i> Tiếp tục mua hàng
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php include_once 'Views/Partials/Footer.php'; ?>
<script>
    $(document).ready(function () {
        $('#clear-cart').click(function () {
            if (confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?')) {
                document.cookie = "cart=; expires=Thu, 30 Apr 1975 11:30:00 UTC; path=/;";
                location.reload();
            }
        });
    });

    $(document).ready(function () {
        $('.quantity-input').change(function () {
            $.ajax({
                url: '/hutech-coffee/cartUpdate',
                type: 'POST',
                data: {
                    id: $(this).data('id'),
                    quantity: $(this).val()
                },
                success: function (response) {
                    location.reload();
                }
            });
        });
    });

    $(document).ready(function () {
        $('#remove-item').click(function () {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm ' + $(this).data('id') + ' khỏi giỏ hàng?')) {
                $.ajax({
                    url: '/hutech-coffee/removeItem',
                    type: 'POST',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
</body>
</html>