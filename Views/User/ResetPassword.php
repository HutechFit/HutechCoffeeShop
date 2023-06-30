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
    <title>Khôi phục mật khẩu</title>
</head>

<body class="main-layout inner_page">
<?php include_once 'Views/Partials/Header.php'; ?>
<?php if (empty($userToken)) : ?>
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
                    <span class="text-danger">Opps!</span> Xin lỗi, không tìm thấy người dùng.
                </p>
                <p class="lead">
                    Hãy thử lại.
                </p>
                <br>
                <a href="mailto:nguyenxuannhan.dev@gmail.com" class="read_more">Liên hệ với chúng tôi</a>
            </div>
        </div>
    <?php else : ?>
        <div class="section blue_bg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="contact">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="titlepage text_align_center">
                                        <h2>Khôi phục mật khẩu</h2>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <form id="request" class="main_form" method="post" action="/change-password"
                                          enctype="multipart/form-data">
                                        <div class="row">
                                            <input type="hidden" name="csrf_token" value="<?= $token ?>">
                                            <input type="hidden" name="token" value="<?= $userToken ?>">
                                            <input title="hidden" name="id" value="<?= $id ?>">
                                            <div class="col-md-12">
                                                <input class="contactus"
                                                       placeholder="Nhập mật khẩu mới"
                                                       type="password"
                                                       name="Password">
                                            </div>
                                            <div class="col-md-12">
                                                <input class="contactus"
                                                       placeholder="Nhập lại mật khẩu mới"
                                                       type="password"
                                                       name="RePassword">
                                            </div>
                                        </div>

                                        <?php if (isset($_SESSION['reset_password_error'])): ?>
                                            <p class="text-danger">
                                                <?=
                                                is_array($_SESSION['reset_password_error'])
                                                    ? implode('<br/>', $_SESSION['reset_password_error'])
                                                    : $_SESSION['reset_password_error'];
                                                unset($_SESSION['reset_password_error'])
                                                ?>
                                            </p>
                                        <?php endif; ?>

                                        <?php if (isset($_SESSION['csrf_error'])): ?>
                                            <p class="text-danger">
                                                <?=
                                                $_SESSION['csrf_error'];
                                                unset($_SESSION['csrf_error']);
                                                ?>
                                            </p>
                                        <?php endif; ?>
                                        <div class="col-md-12">
                                            <button class="send_btn"
                                                    type="submit">Khôi phục mật khẩu
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php include_once 'Views/Partials/Footer.php'; ?>
</body>

</html>