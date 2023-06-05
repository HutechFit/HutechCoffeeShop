<!doctype html>
<html lang="vi">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <title>Danh sách cà phê</title>
</head>

<body class="main-layout inner_page">
	<?php include_once 'Views/Partials/Header.php' ; ?>
    <?php if(empty($coffees)) : ?>
        <div class="d-flex align-items-center justify-content-center vh-25 service"
             style="background: #FFFFFF">
            <div class="text-center">
                <h1 class="display-1 fw-bold text-info">Trống</h1><br>
                <p class="fs-3"> <span class="text-danger">Opps!</span> Có vẻ như bạn chưa thêm cà phê nào.</p>
                <p class="lead">
                    Hãy thêm cà phê mới.
                </p> <br>
                <a href="?uri=add" class="read_more">Thêm cà phê</a>
            </div>
        </div>
    <?php else : ?>
    <div class="d-flex justify-content-lg-center vh-25 service"
         style="background: #FFFFFF">
	<table id="myTable" class="table table-striped">
        <caption>Danh sách cà phê</caption>
		<thead>
			<tr>
				<th scope="col">Mã cà phê</th>
				<th scope="col">Tên cà phê</th>
				<th scope="col">Giá</th>
				<th scope="col">Hình ảnh</th>
				<th scope="col">Mô tả</th>
				<th scope="col">Thao tác</th>
			</tr>
		</thead>
		<tbody>
            <?php foreach ($coffees as $coffee) : ?>
                <tr>
                    <td><?= $coffee->id ?></td>
                    <td><?= $coffee->name ?></td>
                    <td><?= $coffee->price ?></td>
                    <td><?= $coffee->image ?></td>
                    <td><?= $coffee->description ?></td>
                    <td>
                        <a href="/coffee/edit/<?= $coffee->id ?>" class="btn btn-primary">Sửa</a>
                        <a href="/coffee/delete/<?= $coffee->id ?>" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
		</tbody>
    </table>
    </div>
    <div class="text-center">
        <a href="?uri=add" class="read_more">Thêm cà phê</a>
    </div>
    <?php endif; ?>
    <?php include_once 'Views/Partials/Footer.php'; ?>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable({
                "autoWidth": false,
            });
        });
    </script>
</body>

</html>