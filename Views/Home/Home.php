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
    <link rel="shortcut icon" href="./Static/icon/favicon.ico" type="image/x-icon">
    <title>Trang chủ</title>
</head>

<body class="main-layout">
<?php include_once 'Views/Partials/Header.php'; ?>
<div class="full_bg">
    <div class="slider_main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row d_flex">
                        <div class="col-md-5">
                            <div class="zon_text">
                                <h1 data-animation="animated bounceInLeft">
                                    Hutech<br>
                                    Coffee
                                </h1>
                                <p data-animation="animated bounceInLeft">
                                    Chào mừng bạn đến với Hutech Coffee. Nơi bạn có thể thưởng thức những ly cà phê ngon
                                    nhất.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="coff_img">
                                <figure><img loading="lazy" src="./Static/images/coff_img.png" alt="Coffee logo"/>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($products)) : ?>
    <div class="service">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage text_align_center">
                        <h2>Dịch vụ của chúng tôi</h2>
                        <p>Chúng tôi cung cấp những dịch vụ tốt nhất cho bạn
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme">
                        <?php foreach ($products as $product): ?>
                            <div class="item">
                                <div class="service_box text_align_center">
                                    <div class="ser_img">
                                        <figure>
                                            <?php if ($product['image']) : ?>
                                                <img loading="lazy" src="<?= $product['image'] ?>"
                                                     alt="<?= $product['name'] ?>" width="100" height="100">
                                            <?php else : ?>
                                                <img loading="lazy" src="https://fakeimg.pl/100x100?text=No+image"
                                                     alt="<?= $product['name'] ?>" width="100" height="100">
                                            <?php endif; ?>
                                        </figure>
                                    </div>
                                    <h3><?= $product['name'] ?></h3>
                                    <p><?= $product['description'] ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-md-12">
                        <a class="read_more" href="/hutech-coffee/order">Đặt món</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php include_once 'Views/Partials/Footer.php'; ?>
</body>

</html>