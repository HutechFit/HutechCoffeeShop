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
                            <form id="request" class="main_form" method="post" action="/signin">
                                <div class="row">
                                    <input type="hidden" name="csrf_token" value="<?= $token ?>">
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

                                <?php if (isset($_SESSION['csrf_error'])): ?>
                                    <p class="text-danger">
                                        <?=
                                        $_SESSION['csrf_error'];
                                        unset($_SESSION['csrf_error']);
                                        ?>
                                    </p>
                                <?php endif; ?>

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
                                    <?php if (isset($_SESSION['csrf_error'])) : ?>
                                        <div class="col-md-12">
                                            <p class="text-danger">
                                                <?=
                                                $_SESSION['csrf_error'];
                                                unset($_SESSION['csrf_error']);
                                                ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="col-md-12">
                                    <button class="send_btn g-recaptcha"
                                            data-sitekey="<?= $siteKey ?>"
                                            data-callback='onSubmit'
                                            data-action='submit'
                                            type="submit">Đăng nhập
                                    </button>
                                </div>
                            </form>
                            <div class="col-md-12 text-center">
                                <p class="mt-3 text-light">Bạn chưa có tài khoản?
                                    <a class="text-info"
                                       href="/hutech-coffee/register">
                                        Đăng ký
                                    </a>
                                </p>
                                <p class="mt-3 text-light">Quên mật khẩu?
                                    <a class="text-info"
                                       href="/hutech-coffee/forgot-password">
                                        Lấy lại mật khẩu
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
<script src="https://www.google.com/recaptcha/api.js?&render=explicit" async defer></script>
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