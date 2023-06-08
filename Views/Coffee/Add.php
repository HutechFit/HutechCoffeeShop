<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thêm sản phẩm</title>
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
                                    <h2>Thêm sản phẩm</h2>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <form id="request" class="main_form" method="post" action="/hutech-coffee/insert" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <input class="contactus" placeholder="Mã sản phẩm" type="number" name="Id">
                                        </div>
                                        <div class="col-md-12 ">
                                            <input class="contactus" placeholder="Tên sản phẩm" type="text" name="Name">
                                        </div>
                                        <div class="col-md-12">
                                            <input class="contactus" placeholder="Giá tiền" type="number" name="Price">
                                        </div>
                                        <div class="col-md-12">
                                            <input class="contactus" placeholder="Hình ảnh" type="file" name="Image" id="Image">
                                        </div>
                                        <div class="col-md-12">
                                            <textarea class="textarea" placeholder="Mô tả sản phẩm" type="type" name="Description"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <input class="contactus" placeholder="Loại sản phẩm" type="text" name="Category">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button name="submit" type="submit" class="send_btn">Thêm</button>
                                    </div>
                                </form>
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