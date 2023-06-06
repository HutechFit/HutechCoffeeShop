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
                                <h2>Sửa sản phẩm</h2>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <form id="request" class="main_form" method="post" action="?uri=add" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" name="Id" value="<?php echo $coffee->Id; ?>">
                                    <div class="col-md-12 ">
                                        <input class="contactus form-control" placeholder="Tên sản phẩm" type="text" name="Name" value="<?php echo $coffee->Name; ?>"
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus form-control" placeholder="Giá tiền" type="number" name="Price" value="<?php echo $coffee->Price; ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <input class="contactus form-control" placeholder="Hình ảnh" type="file" name="Image">
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="textarea form-control" placeholder="Mô tả sản phẩm" type="type" name="Description">
                                            <?php echo $coffee->Description; ?>
                                        </textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <select class="contactus form-control" name="CategoryId">
                                            <option value="1">Cà phê</option>
                                            <option value="2">Trà</option>
                                            <option value="3">Sinh tố</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="send_btn">Thêm</button>
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