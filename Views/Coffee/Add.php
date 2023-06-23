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
                                <form id="request" class="main_form" method="post" action="/insert" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <input class="contactus" placeholder="Tên sản phẩm" type="text" name="Name">
                                            <div class="col-md-12">
                                                <?php if (isset($_SESSION['name_error'])) : ?>
                                                    <p class="text-danger">
                                                        <?=
                                                        $_SESSION['name_error'];
                                                        unset($_SESSION['name_error']);
                                                        ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <input class="contactus" placeholder="Giá tiền" type="number" name="Price" step="1000" min="0" max="100000000">
                                            <div class="col-md-12">
                                                <?php if (isset($_SESSION['price_error'])) : ?>
                                                    <p class="text-danger">
                                                        <?=
                                                        $_SESSION['price_error'];
                                                        unset($_SESSION['price_error']);
                                                        ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <input class="contactus" placeholder="Hình ảnh" type="file" name="Image" id="Image">
                                            <?php if (isset($_SESSION['image_error'])) : ?>
                                                <div class="col-md-12">
                                                    <p class="text-danger">
                                                        <?=
                                                        is_array($_SESSION['image_error'])
                                                            ? implode('<br/>', $_SESSION['image_error'])
                                                            : $_SESSION['image_error'];
                                                        unset($_SESSION['image_error'])
                                                        ?>
                                                    </p>
                                                </div>
                                                <?php ; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea class="textarea" placeholder="Mô tả sản phẩm" type="type" name="Description"></textarea>
                                            <div class="col-md-12">
                                                <?php if (isset($_SESSION['description_error'])) : ?>
                                                    <p class="text-danger">
                                                        <?=
                                                        $_SESSION['description_error'];
                                                        unset($_SESSION['description_error']);
                                                        ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <select class="contactus" name="category_id" aria-label="category_id">
                                                <?php foreach ($categories as $category) : ?>
                                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
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