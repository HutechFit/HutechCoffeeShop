<!doctype html>
<html lang="vi">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Trang chủ</title>
</head>

<body class="main-layout">
	<?php include_once 'Views/Partials/Header.php'; ?>
	<div class="full_bg">
		<div class="slider_main">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="row d_flex">
							<div class="col-md-5">
								<div class="zon_text">
									<h1 data-animation="animated bounceInLeft">
										Hutech<br>
										Coffee
									</h1>
									<p data-animation="animated bounceInLeft">
										Chào mừng bạn đến với Hutech Coffee. Nơi bạn có thể thưởng thức những ly cà phê ngon nhất.
									</p>
								</div>
							</div>
							<div class="col-md-7">
								<div class="coff_img">
									<figure><img src="./Static/images/coff_img.png" alt="Coffee logo" /></figure>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="service">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="titlepage text_align_center">
						<h2>Dịch vụ của chúng tôi</h2>
						<p>Chúng tôi cung cấp những dịch vụ tốt nhất cho bạn
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="owl-carousel owl-theme">
						<div class="item">
							<div class="service_box text_align_center">
								<div class="ser_img">
									<figure><img src="./Static/images/ser_img1.png" alt="#" /></figure>
								</div>
								<h3>Cappuccino Coffee</h3>
								<p>Cà phê mang đậm hương vị của sữa tươi và bọt sữa
								</p>
							</div>
						</div>
						<div class="item">
							<div class="service_box text_align_center">
								<div class="ser_img">
									<figure><img src="./Static/images/ser_img3.png" alt="#" /></figure>
								</div>
								<h3>Cà phê đen</h3>
								<p>Cà phê đen mang đậm hương vị của cà phê
								</p>
							</div>
						</div>
						<div class="item">
							<div class="service_box text_align_center">
								<div class="ser_img">
									<figure><img src="./Static/images/ser_img2.png" alt="#" /></figure>
								</div>
								<h3>Cà phê moka</h3>
								<p>Cà phê mang đậm hương vị của cacao
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<a class="read_more" href="/hutech-coffee/order">Đặt món</a>
				</div>
			</div>
		</div>
	</div>
	<?php include_once 'Views/Partials/Footer.php'; ?>
</body>

</html>