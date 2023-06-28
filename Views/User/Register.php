<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng ký</title>
</head>

<body class="main-layout inner_page">
<?php include_once 'Views/Partials/Header.php'; ?>
<div class="section blue_bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="contact">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="titlepage text_align_center">
                                <h2>Đăng ký</h2>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <form id="request" class="main_form" method="post" action="/signup"
                                  enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input class="contactus"
                                               placeholder="Họ tên khách hàng"
                                               type="text"
                                               name="Name"
                                               required>
                                        <?php if (isset($_SESSION['full_name_error'])): ?>
                                            <p class="text-danger">
                                                <?=
                                                $_SESSION['full_name_error'];
                                                unset($_SESSION['full_name_error']);
                                                ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus"
                                               placeholder="Email"
                                               type="email"
                                               name="Email"
                                               required>
                                        <?php if (isset($_SESSION['email_error'])): ?>
                                            <?php foreach ($_SESSION['email_error'] as $error): ?>
                                                <p class="text-danger">
                                                    <?= $error ?>
                                                </p>
                                            <?php endforeach; ?>
                                            <?php unset($_SESSION['email_error']); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus"
                                               placeholder="Mật khẩu"
                                               type="password"
                                               name="Password"
                                               required>
                                        <?php if (isset($_SESSION['password_error'])): ?>
                                            <p class="text-danger">
                                                <?=
                                                $_SESSION['password_error'];
                                                unset($_SESSION['password_error']);
                                                ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus"
                                               placeholder="Nhập lại mật khẩu"
                                               type="password"
                                               name="RePassword"
                                               required>
                                        <?php if (isset($_SESSION['password_confirm_error'])): ?>
                                            <p class="text-danger">
                                                <?=
                                                $_SESSION['password_confirm_error'];
                                                unset($_SESSION['password_confirm_error']);
                                                ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="send_btn">Đăng Ký</button>
                                </div>
                            </form>
                            <div class="col-md-12 text-center">
                                <p class="mt-3 text-light">Đã có tài khoản? <a class="text-info" href="/login">Đăng
                                        nhập</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'Views/Partials/Footer.php'; ?>
</body>

</html>