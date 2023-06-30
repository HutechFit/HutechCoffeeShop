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
    <meta name="geo.placename" content="Ho Chi Minh" />
    <link rel="shortcut icon" href="./Static/icon/favicon.ico" type="image/x-icon">
    <title>Xác thực email</title>
</head>
<body class="main-layout inner_page">
<?php include_once 'Views/Partials/Header.php'; ?>
<?php if(empty($token)) : ?>
<div class="d-flex
                align-items-center
                justify-content-center
                vh-25
                service"
     style="background: #FFFFFF">
    <div class="text-center">
        <h1 class="display-1
                   fw-bold
                   text-info">Không tìm thấy</h1><br>
        <p class="fs-3">
            <span class="text-danger">Opps!</span> Không tìm thấy mã xác thực.
        </p>
        <p class="lead">
            Hãy thử lại.
        </p>
        <br>
        <a href="/" class="read_more">Trang chủ</a>
    </div>
</div>
<?php else : ?>
    <?php if (!$isExistUser) : ?>
        <div class="d-flex
                align-items-center
                justify-content-center
                vh-25
                service"
             style="background: #FFFFFF">
            <div class="text-center">
                <h1 class="display-1
                   fw-bold
                   text-danger">Thất bại</h1><br>
                <p class="fs-3">
                    <span class="text-danger">Opps!</span> Xin lỗi, xác thực không thành công.
                </p>
                <p class="lead">
                    Hãy thử lại.
                </p>
                <br>
                <a href="/resend" class="read_more">Xác thực lại</a>
            </div>
        </div>
    <?php else : ?>
        <div class="d-flex
                align-items-center
                justify-content-center
                vh-25
                service"
             style="background: #FFFFFF">
            <div class="text-center">
                <h1 class="display-1
                   fw-bold
                   text-success">Thành công</h1><br>
                <p class="fs-3">
                    <span class="text-success">OK!</span> Xin chúc mừng, xác thực thành công.
                </p>
                <p class="lead">
                    Hãy đăng nhập để tiếp tục.
                </p>
                <br>
                <a href="/login" class="read_more">Đăng nhập</a>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php include_once 'Views/Partials/Footer.php'; ?>
</body>
</html>