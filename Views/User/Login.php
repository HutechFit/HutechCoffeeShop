<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
                                <form id="request" class="main_form" method="post" action="?uri=add" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <input class="contactus" placeholder="Tài khoản" type="text" name="Username">
                                        </div>
                                        <div class="col-md-12">
                                            <input class="contactus" placeholder="Mật khẩu" type="password" name="Password">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="send_btn">Đăng nhập</button>
                                    </div>
                                </form>
                                <div class="col-md-12 text-center">
                                    <p class="mt-3 text-light">Bạn chưa có tài khoản? <a class="text-info" href="/hutech-coffee/register">Đăng ký</a></p>
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