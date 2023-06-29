<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="shortcut icon" href="./Static/icon/favicon.ico" type="image/x-icon">
    <title>Danh sách cà phê</title>
</head>

<body class="main-layout inner_page">
<?php include_once 'Views/Partials/Header.php'; ?>
<?php if (empty($coffees)) : ?>
    <div class="d-flex align-items-center justify-content-center vh-25 service"
         style="background: #FFFFFF">
        <div class="text-center">
            <h1 class="display-1 fw-bold text-info">Trống</h1><br>
            <p class="fs-3"><span class="text-danger">Opps!</span> Có vẻ như bạn chưa thêm sản phẩm nào.</p>
            <p class="lead">
                Hãy thêm sản phẩm mới.
            </p> <br>
            <a href="/hutech-coffee/add" class="read_more">Thêm sản phẩm</a>
        </div>
    </div>
<?php else : ?>
    <div class="d-flex justify-content-lg-center vh-25 service"
         style="background: #FFFFFF">
        <table id="myTable" class="table table-striped table-hover">
            <caption>Danh sách sản phẩm</caption>
            <thead>
            <tr>
                <th scope="col">Mã sản phẩm</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Giá</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Loại sản phẩm</th>
                <th scope="col">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($coffees as $coffee) : ?>
                <tr>
                    <td><?= $coffee['id'] ?></td>
                    <td><?= $coffee['name'] ?></td>
                    <td>
                        <?php if ($coffee['price']) : ?>
                            <?= numfmt_format_currency(numfmt_create('vi_VN', NumberFormatter::CURRENCY), $coffee['price'], 'VND') ?>
                        <?php else : ?>
                            <?= numfmt_format_currency(numfmt_create('vi_VN', NumberFormatter::CURRENCY), 0, 'VND') ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($coffee['image']) : ?>
                            <img loading="lazy" src="<?= $coffee['image'] ?>" alt="<?= $coffee['name'] ?>" width="100"
                                 height="100">
                        <?php else : ?>
                            <img loading="lazy" src="https://fakeimg.pl/100x100?text=No+image"
                                 alt="<?= $coffee['name'] ?>" width="100" height="100">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($coffee['description']) : ?>
                            <?= $coffee['description'] ?>
                        <?php else : ?>
                            <i>Chưa có mô tả</i>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($coffee['category_id']) : ?>
                            <?= $categories[$coffee['category_id'] - 1]['name'] ?>
                        <?php else : ?>
                            <i>Chưa phân loại</i>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/hutech-coffee/edit?id=<?= $coffee['id'] ?>" class="btn btn-info">Sửa</a>
                        <a href="/hutech-coffee/delete?id=<?= $coffee['id'] ?>" class="btn btn-danger"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <a href="/hutech-coffee/add" class="read_more">Thêm sản phẩm</a>
    </div>
<?php endif; ?>
<?php include_once 'Views/Partials/Footer.php'; ?>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "autoWidth": false,
            "language": {
                "lengthMenu": "Hiển thị _MENU_ dòng",
                "zeroRecords": "Không tìm thấy dữ liệu",
                "info": "Hiển thị trang _PAGE_ trên _PAGES_",
                "infoEmpty": "Không có dữ liệu",
                "infoFiltered": "(lọc từ _MAX_ dòng)",
                "search": "Tìm kiếm:",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Sau",
                    "previous": "Trước"
                },
            },
        });
    });
</script>
</body>

</html>