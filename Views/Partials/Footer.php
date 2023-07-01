<footer>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="infoma text_align_left">
                                <h3>Danh mục</h3>
                                <ul class="menu_bottom">
                                    <li><a href="/hutech-coffee">Trang chủ</a></li>
                                    <li><a href="/hutech-coffee/order">Gọi món</a></li>
                                    <li><a href="/hutech-coffee/cart">Giỏ hàng</a></li>
                                    <li><a href="/hutech-coffee/manager">Quản lý</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="infoma text_align_left">
                                <h3>Cửa hàng</h3>
                                <ul class="menu_bottom">
                                    <li><a href="https://goo.gl/maps/RY8BfSCW1QU23sEG9">Điện Biên Phủ, Bình Thạnh</a>
                                    </li>
                                    <li><a href="https://goo.gl/maps/wjeUiyaaDPR1PNkr8">Ung Văn Khiêm, Bình Thạnh</a>
                                    </li>
                                    <li><a href="https://goo.gl/maps/p7Dkc1jdv5hiWZ7p9">Khu Công Nghệ Cao, Thủ Đức</a>
                                    </li>
                                    <li><a href="https://goo.gl/maps/7hzGyBW6M9qX7KbN6">Xa Lộ Hà Nội, Thủ Đức</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="infoma">
                        <h3>Thông tin</h3>
                        <ul class="social_icon">
                            <li><a href="https://www.facebook.com/itHutech"><i class="fa fa-facebook"
                                                                               aria-hidden="true"></i></a></li>
                            <li><a href="https://www.hutech.edu.vn/"><i class="fa fa-globe" aria-hidden="true"></i></a>
                            </li>
                            <li><a href="https://www.youtube.com/@ITHUTECHCHANNEL"><i class="fa fa-youtube-play"
                                                                                      aria-hidden="true"></i></a></li>
                        </ul>
                        <ul class="conta">
                            <li><i class="fa fa-map-marker" aria-hidden="true"></i> Hồ Chí Minh
                            </li>
                            <li><i class="fa fa-phone" aria-hidden="true"></i>Gọi (028) 5445 77770</li>
                            <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:hutech@hutech.edu.vn">
                                    hutech@hutech.edu.vn</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p>© <?= date("Y"); ?>
                            Đã đăng ký Bản quyền. <a href="https://www.hutech.edu.vn/"> Hutech Coffeee</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="./Static/js/jquery.min.js"></script>
<script src="./Static/js/bootstrap.bundle.min.js"></script>
<script src="./Static/js/jquery-3.0.0.min.js"></script>
<script src="./Static/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script src="./Static/js/owl.carousel.min.js"></script>
<script src="./Static/js/custom.js"></script>

<script>
    $(document).ready(function () {
        const currentPath = window.location.pathname;
        $('#navbar li a[href="' + '/hutech-coffee' + currentPath + '"]').parent().addClass('active');

        $(window).scroll(function(){
            const showAfter = 100;
            if ($(this).scrollTop() > showAfter ) {
                $('.back-to-top').fadeIn();
            } else {
                $('.back-to-top').fadeOut();
            }
        });

        $('.back-to-top').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });
    });
</script>