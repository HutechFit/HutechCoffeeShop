<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập</title>
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
                                <h2>Đăng nhập</h2>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <form id="request" class="main_form" method="post" action="/signin"
                                  enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <input class="contactus"
                                               placeholder="Tài khoản"
                                               type="email"
                                               name="Email"
                                               id="email">
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus"
                                               placeholder="Mật khẩu"
                                               type="password"
                                               name="Password">
                                    </div>
                                </div>

                                <?php if (isset($_SESSION['account_error'])) : ?>
                                    <div class="col-md-12">
                                        <p class="text-danger">
                                            <?=
                                            $_SESSION['account_error'];
                                            unset($_SESSION['account_error']);
                                            ?>
                                        </p>
                                    </div>
                                <?php elseif (isset($_SESSION['verify_error'])) : ?>
                                    <div class="col-md-12">
                                        <p class="text-danger">
                                            <?=
                                            $_SESSION['verify_error'];
                                            unset($_SESSION['verify_error']);
                                            ?>&nbsp;
                                            <button class="btn-outline-info" id="resend">Gửi lại email xác thực</button>
                                        </p>
                                    </div>
                                    <?php if (isset($_SESSION['token_resend_error'])) : ?>
                                        <div class="col-md-12">
                                            <p class="text-danger">
                                                <?=
                                                $_SESSION['token_resend_error'];
                                                unset($_SESSION['token_resend_error']);
                                                ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <div class="col-md-12">
                                    <button class="send_btn"
                                            type="submit">Đăng nhập</button>
                                </div>
                            </form>
                            <div class="col-md-12 text-center">
                                <p class="mt-3 text-light">Bạn chưa có tài khoản?
                                    <a class="text-info"
                                       href="/hutech-coffee/register">
                                        Đăng ký
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
                url: '/resend',
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