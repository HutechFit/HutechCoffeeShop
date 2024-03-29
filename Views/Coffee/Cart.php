<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Hutech cofee là nơi bạn có thể thưởng thức những ly cà phê ngon nhất.">
    <meta name="keywords" content="Hutech, Coffee, Cà phê, Cà phê ngon, Cà phê hutech, Hutech coffee">
    <meta name="author" content="Hutech Coffee">
    <meta name="geo.placename" content="Ho Chi Minh"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          crossorigin="anonymous"
          referrerpolicy="no-referrer"/>
    <link rel="shortcut icon" href="./Static/icon/favicon.ico" type="image/x-icon">
    <title>Giỏ hàng</title>
</head>
<body class="main-layout inner_page">
<?php include_once 'Views/Partials/Header.php'; ?>
<?php if (empty($cart)) : ?>
    <div class="d-flex
                align-items-center
                justify-content-center
                vh-25">
        <div class="text-center">
            <h1 class="display-1
                       fw-bold
                       text-info">Chưa có món nào</h1><br>
            <p class="fs-3"><span class="text-danger">Opps!</span> Giỏ hàng của bạn đang trống.</p>
            <p class="lead">
                Vui đặt món để thưởng thức những ly cà phê thơm ngon.
            </p> <br>
            <a href="/hutech-coffee/order"
               class="read_more">Đặt món</a>
        </div>
    </div>
<?php else : ?>
    <?php if (isset($_SESSION['csrf_error'])): ?>
        <p class="alert-danger">
            <?=
            $_SESSION['csrf_error'];
            unset($_SESSION['csrf_error']);
            ?>
        </p>
    <?php endif; ?>
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
                                    <div class="col-lg-3
                                                col-md-12
                                                mb-4
                                                mb-lg-0">
                                        <div class="bg-image
                                                    hover-overlay
                                                    hover-zoom
                                                    ripple rounded"
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
                                                       max="100"
                                                       type="number"
                                                       value="<?= $item['quantity'] ?>"
                                                       data-id="<?= $item['id'] ?>"
                                                       class="form-control quantity-input"/>
                                                <label class="form-label"
                                                       for="form1">Số lượng</label>
                                            </div>
                                            <button id="remove-item"
                                                    class="btn
                                                           btn-danger
                                                           btn-sm
                                                           me-1
                                                           mb-2"
                                                    type="button"
                                                    data-id="<?= $item['id'] ?>"
                                                    data-mdb-toggle="tooltip"
                                                    title="Xoá sản phẩm">
                                                <i class="fas fa-trash" style="color: white"></i>
                                            </button>
                                        </div>

                                        <p class="text-start text-md-center">
                                            <strong>
                                                <?= numfmt_format_currency(
                                                    numfmt_create('vi_VN', NumberFormatter::CURRENCY),
                                                    $item['price'] * $item['quantity'], 'VND'
                                                ) ?>
                                            </strong>
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
                                           class="form-control
                                                  form-control-lg
                                                  discount-input"
                                           placeholder="Nhập mã giảm giá"/>
                                    <label class="form-label"
                                           for="form1"></label>
                                    <?php if (isset($_SESSION['discount'])): ?>
                                        <div class="alert
                                                alert-success
                                                alert-dismissible
                                                fade show" role="alert">
                                            Đã áp dụng mã giảm giá <b><?= $_SESSION['discount'] ?></b> thành công!
                                            <button type="button"
                                                    class="close"
                                                    id="unDiscount"
                                                    data-dismiss="alert"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php elseif (isset($_SESSION['discount_error'])): ?>
                                        <div class="alert
                                                alert-danger
                                                alert-dismissible
                                                fade show"
                                             role="alert">
                                            <?=
                                            $_SESSION['discount_error'];
                                            unset($_SESSION['discount_error']);
                                            ?>
                                            <button type="button"
                                                    class="close"
                                                    data-dismiss="alert"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <button type="button"
                                        id="apply-discount"
                                        class="btn
                                               btn-outline-warning
                                               btn-lg
                                               ms-3">
                                    Áp dụng
                                </button>
                                <?php if (isset($_SESSION['csrf_error'])): ?>
                                    <p class="text-danger">
                                        <?=
                                        $_SESSION['csrf_error'];
                                        unset($_SESSION['csrf_error']);
                                        ?>
                                    </p>
                                <?php endif; ?>
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
                                 src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png"
                                 alt="PayPal"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0 text-dark">Tổng tiền</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group
                                       list-group-flush">
                                <li class="list-group-item
                                           d-flex
                                           justify-content-between
                                           border-0
                                           px-0">
                                    Sản phẩm
                                    <span>
                                        <?= numfmt_format_currency(
                                            numfmt_create('vi_VN', NumberFormatter::CURRENCY),
                                            array_sum(
                                                array_map(
                                                    function ($item) {
                                                        return $item['price'] * $item['quantity'];
                                                    },
                                                    $cart
                                                )
                                            ),
                                            'VND'
                                        ) ?>
                                </span>
                                </li>
                                <?php if (isset($_SESSION['discount'])): ?>
                                    <li class="list-group-item
                                           d-flex
                                           justify-content-between
                                           border-0
                                           px-0">
                                        <p>Giảm giá</p>
                                        <span>-<?= $_SESSION['value'] ?? 0 ?></span>
                                    </li>
                                <?php endif; ?>
                                <li class="list-group-item
                                           d-flex
                                           justify-content-between
                                           border-0
                                           px-0">
                                    <div>
                                        <strong>Tổng số tiền</strong>
                                        <p class="mb-0">(đã bao gồm 5% VAT)</p>
                                    </div>
                                    <span>
                                        <?= numfmt_format_currency(
                                            numfmt_create('vi_VN', NumberFormatter::CURRENCY),
                                            max(0, ceil(
                                                    array_sum(array_map(function ($item) {
                                                            return $item['price'] * $item['quantity'] * 1.05 - ($_SESSION['total'] ?? 0);
                                                        }, $cart)
                                                    ) / 1000
                                                ) * 1000),
                                            'VND'
                                        ) ?>
                                    </span>
                                </li>
                            </ul>

                            <div id="payment-info"
                                 style="display: none">
                                <form action="/checkout" id="frmCreateOrder" method="post">
                                    <label>
                                        <input type="hidden"
                                               name="amount"
                                               value="<?= max(0, ceil(
                                                       array_sum(
                                                           array_map(function ($item) {
                                                               return $item['price'] * $item['quantity'] * 1.05 - ($_SESSION['total'] ?? 0);
                                                           }, $cart)
                                                       ) / 1000
                                                   ) * 1000) ?>">
                                    </label>

                                    <div class="form-group">
                                        <input type="hidden" name="csrf_token" value="<?= $token ?>">
                                        <input type="email"
                                               class="form-control"
                                               id="email"
                                               name="email"
                                               placeholder="Nhập email của bạn"
                                               value="<?= $_SESSION['user']['email'] ?? '' ?>"
                                               required>
                                        <label for="email"></label>
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control"
                                                id="payment-method"
                                                name="payment-method">
                                            <option value="vnpay">VNPay</option>
                                            <option value="striped">Striped</option>
                                            <option value="paypal">PayPal</option>
                                        </select>
                                        <label for="payment-method"></label>
                                    </div>
                                    <button type="submit"
                                            id="payment"
                                            class="btn btn-outline-success btn-lg btn-block">
                                        Thanh toán
                                    </button>
                                </form>
                            </div>
                            <button type="button"
                                    id="checkout"
                                    class="btn btn-outline-info btn-lg btn-block">
                                Tiến hành thanh toán
                            </button>
                            <br>
                            <?php if (isset($_SESSION['payment_error'])) {
                                echo '<p class="text-danger justify-content-center">' . $_SESSION['payment_error'] . '</p>';
                                unset($_SESSION['payment_error']);
                            } ?>
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
                document.cookie = 'cart=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=hutech-coffee.local; samesite=Strict; secure';
                location.reload();
            }
        });

        $('.quantity-input').change(function () {
            $.ajax({
                url: '/cartUpdate',
                type: 'POST',
                data: {
                    id: $(this).data('id'),
                    quantity: $(this).val(),
                    csrf_token: '<?= $token ?>'
                },
                success: function () {
                    location.reload();
                }
            });
        });

        $('#remove-item').click(function () {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm ' + $(this).data('id') + ' khỏi giỏ hàng?')) {
                $.ajax({
                    url: '/removeItem',
                    type: 'POST',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function () {
                        location.reload();
                    }
                });
            }
        });

        $('#checkout').click(function () {
            $('#payment-info').show();
            $('#checkout').hide();
        });

        $('#apply-discount').click(function () {
            $.ajax({
                url: '/discount',
                type: 'POST',
                data: {
                    code: $('.discount-input').val(),
                    csrf_token: '<?= $token ?>'
                },
                success: function () {
                    location.reload();
                }
            });
        });

        $('#unDiscount').click(function () {
            $.ajax({
                url: '/unDiscount',
                type: 'POST',

                success: function () {
                    location.reload();
                }
            });
        });
    });
</script>
</body>
</html>