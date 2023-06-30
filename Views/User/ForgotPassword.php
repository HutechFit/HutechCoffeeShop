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
    <title>Quên mật khẩu</title>
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
                                <h2>Quên mật khẩu</h2>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <form id="request" class="main_form" method="post" action="/send-forgot-password"
                                  enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" name="csrf_token" value="<?= $token ?>">
                                    <div class="col-md-12 ">
                                        <input class="contactus"
                                               placeholder="Nhâp email của bạn"
                                               type="email"
                                               name="Email"
                                               id="email">
                                        <?php if (isset($_SESSION['email_forgot_error'])): ?>
                                            <p class="text-danger">
                                                <?=
                                                $_SESSION['email_forgot_error'];
                                                unset($_SESSION['email_forgot_error']);
                                                ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>

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
                                            type="submit">Lấy lại mật khẩu</button>
                                </div>
                            </form>
                            <div class="col-md-12 text-center">
                                <p class="mt-3 text-light">Quay lại trang
                                    <a class="text-info"
                                       href="/login">
                                        Đăng nhập
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'Views/Partials/Footer.php'; ?>
<script>
    $(document).ready(function () {
        $('#resend').click(function () {
            $.ajax({
                url: '/send-forgot-password',
                type: 'POST',
                data {
                    email: $('#email').val()
                }
                success: function (response) {
                    if (response.success) {
                        alert('Gửi email thành công');
                    } else {
                        alert('Gửi email thất bại');
                    }
                }
            });
        });
    });
</script>
</body>

</html>