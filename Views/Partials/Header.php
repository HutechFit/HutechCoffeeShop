<link rel="stylesheet" href="./Static/css/bootstrap.min.css">
<link rel="stylesheet" href="./Static/css/style.css">
<link rel="stylesheet" href="./Static/css/responsive.css">
<link rel="stylesheet" href="./Static/css/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" href="./Static/css/owl.carousel.min.css">
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<link rel="stylesheet" href="https://rawgit.com/LeshikJanz/libraries/master/Bootstrap/baguetteBox.min.css">

<div class="header">
	<div class="container-fluid">
		<div class="row d_flex">
			<div class="col-xl-1 col-lg-3 col-sm-2 col logo_section">
				<div class="full">
					<div class="center-desk">
						<div class="logo">
							<a href="?uri=/">Hutech</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-7 col-lg-9 col-md-10 col-sm-12">
				<nav class="navigation navbar navbar-expand-md navbar-dark ">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarsExample04">
						<ul class="navbar-nav mr-auto">
							<li class="nav-item ">
								<a class="nav-link" href="?uri=/">Trang chủ</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="?uri=order">Gọi món</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="?uri=cart">Giỏ hàng</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="?uri=manager">Quản lý</a>
							</li>
							<?php if (isset($_SESSION['user'])) : ?>
								<li class="nav-item">
									<a class="nav-link" href="?uri=logout">Đăng xuất</a>
								</li>
							<?php else : ?>
								<li class="nav-item">
									<a class="nav-link" href="?uri=login">Đăng nhập</a>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				</nav>
			</div>
			<div class="col-md-4 re_no">
				<ul class="infomaco">
					<li><i class="fa fa-phone" aria-hidden="true"></i> (028) 5445 7777</li>
					<li><a href="Javascript:void(0)"><i class="fa fa-envelope-o" aria-hidden="true"></i> hutech@hutech.edu.vn</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>