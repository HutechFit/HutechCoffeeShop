<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gọi món</title>
</head>
<body class="main-layout  inner_page">
<?php include_once 'Views/Partials/Header.php'; ?>
<div class="blog">
    <div class="container">
        <?php if (empty($coffees)) : ?>
            <div class="d-flex align-items-center justify-content-center vh-25">
                <div class="text-center">
                    <h1 class="display-1 fw-bold text-info">Trống</h1><br>
                    <p class="fs-3"><span class="text-danger">Opps!</span> Hiện tại cửa hàng chưa có sản phẩm nào.</p>
                    <p class="lead">
                        Vui lòng quay lại sau.
                    </p> <br>
                    <a href="/hutech-coffee/" class="read_more">Trở về trang chủ</a>
                </div>
            </div>
        <?php else : ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage text_align_center">
                        <h2>Gọi <span class="blue whitebg">Món</span></h2>
                        <p>Thêm món yêu thích của bạn vào giỏ hàng</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($coffees as $coffee): ?>
                    <div class="col-md-6">
                        <div class="blog-box">
                            <figure>
                                <?php if ($coffee['image']) : ?>
                                    <img loading="lazy" src="<?= $coffee['image'] ?>" alt="<?= $coffee['name'] ?>">
                                <?php else : ?>
                                    <img loading="lazy" src="https://fakeimg.pl/100x100?text=No+image"
                                         alt="<?= $coffee['name'] ?>">
                                <?php endif; ?>
                                <button class="text-white addToCart"
                                        data-name="<?= $coffee['name'] ?>"
                                        data-id="<?= $coffee['id'] ?>"
                                        data-price="<?= $coffee['price'] ?>"
                                        data-image="<?= $coffee['image'] ?>">
                                    <div class="date">
                                        <h3>Mua</h3>
                                    </div>
                                </button>
                            </figure>
                            <div class="blog_text">
                                <h3 data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="<?= $coffee['description'] ?>">
                                    <?= $coffee['name'] ?>
                                </h3>
                                <p>
                                    <?php if ($coffee['price']) : ?>
                                        <?= numfmt_format_currency(numfmt_create('vi_VN', NumberFormatter::CURRENCY), $coffee['price'], 'VND') ?>
                                    <?php else : ?>
                                        Miễn phí
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include_once 'Views/Partials/Footer.php'; ?>
<script>
    $(document).ready(function () {
        $('.addToCart').click(function (e) {
            e.preventDefault();
            let data = {
                id: $(this).data('id'),
                name: $(this).data('name'),
                price: $(this).data('price'),
                image: $(this).data('image'),
                quantity: 1
            };
            if (confirm('Xác nhận thêm ' + $(this).data('name').toLowerCase() + ' vào giỏ hàng?')) {
                $.ajax({
                    url: '/addToCart',
                    method: 'POST',
                    data: data,
                    success: function (response) {
                        if (response) {
                            alert('Thêm vào giỏ hàng thành công');
                            $('.cart').load(location.href + ' .header .cart');
                        } else {
                            alert('Thêm vào giỏ hàng thất bại');
                        }
                    }
                });
            }
        });
    });
</script>
</body>
</html>