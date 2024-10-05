<?php
if (empty($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["id_user"]))
    header('Location: index.php');

if (isset($_SESSION['couponApplyed']))
    unset($_SESSION["couponApplyed"]);

?>
<!doctype html>
<html class="no-js" lang="en">

<?php include 'templates/head.php'; ?>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrapper fixed__footer">
        <!-- Start Header Style -->
        <?php include 'templates/header.php'; ?>
        <!-- End Header Style -->
        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <?php include 'templates/search.php'; ?>
            <!-- End Search Popap -->
            <!-- Start Offset MEnu -->
            <div class="offsetmenu">
                <div class="offsetmenu__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="off__contact">
                        <div class="logo">
                            <a href="index.html">
                                <img src="images/logo/logo.png" alt="logo">
                            </a>
                        </div>
                        <p>Viết gì ở đây?</p>
                    </div>
                    <ul class="sidebar__thumd">
                        <li><a href="#"><img src="images/sidebar-img/1.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/2.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/3.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/4.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/5.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/6.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/7.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/8.jpg" alt="hình ảnh thanh bên"></a></li>
                    </ul>
                    <div class="offset__widget">
                        <div class="offset__single">
                            <h4 class="offset__title">Ngôn ngữ</h4>
                            <ul>
                                <li><a href="#"> Tiếng Anh </a></li>
                                <li><a href="#"> Tiếng Pháp </a></li>
                                <li><a href="#"> Tiếng Đức </a></li>
                            </ul>
                        </div>
                        <div class="offset__single">
                            <h4 class="offset__title">Tiền tệ</h4>
                            <ul>
                                <li><a href="#"> USD : Đô la </a></li>
                                <li><a href="#"> EUR : Euro </a></li>
                                <li><a href="#"> POU : Bảng Anh </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="offset__sosial__share">
                        <h4 class="offset__title">Theo dõi chúng tôi trên mạng xã hội</h4>
                        <ul class="off__soaial__link">
                            <li><a class="bg--twitter" href="#" title="Twitter"><i class="zmdi zmdi-twitter"></i></a></li>

                            <li><a class="bg--instagram" href="#" title="Instagram"><i class="zmdi zmdi-instagram"></i></a></li>

                            <li><a class="bg--facebook" href="#" title="Facebook"><i class="zmdi zmdi-facebook"></i></a></li>

                            <li><a class="bg--googleplus" href="#" title="Google Plus"><i class="zmdi zmdi-google-plus"></i></a></li>

                            <li><a class="bg--google" href="#" title="Google"><i class="zmdi zmdi-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Offset MEnu -->
        </div>
        <!-- Kết thúc Offset Wrapper -->
        <!-- Bắt đầu khu vực Bradcaump -->
        <?php
        include 'templates/bradcaump.php';

        renderBradcaump(
            'Trợ giúp',
            [
                ['url' => 'index.php', 'text' => 'Trang chủ / '],
                ['text' => 'Trợ giúp']
            ]
        ); ?>

        <!-- Kết thúc khu vực Bradcaump -->
        <!-- Bắt đầu khu vực Liên hệ -->
        <section class="htc__contact__area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="htc__contact__container">
                            
                            <style>
                            .dropdown {
                                position: relative;
                                display: inline-block;
                                width: 100%;
                                margin-bottom: 15px;
                            }
                            
                            .dropdown-toggle {
                                width: 100%;
                                padding: 10px 15px;
                                background-color: #f8f8f8;
                                border: 1px solid #ddd;
                                border-radius: 4px;
                                cursor: pointer;
                                text-align: left;
                                font-size: 16px;
                            }
                            
                            .dropdown-toggle::after {
                                content: '\25BC';
                                float: right;
                            }
                            
                            .dropdown-menu {
                                display: none;
                                position: absolute;
                                background-color: #f9f9f9;
                                min-width: 100%;
                                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                                z-index: 1;
                                border-radius: 0 0 4px 4px;
                            }
                            
                            .dropdown-menu a {
                                color: black;
                                padding: 12px 16px;
                                text-decoration: none;
                                display: block;
                            }
                            
                            .dropdown-menu a:hover {
                                background-color: #f1f1f1;
                            }
                            
                            .show {
                                display: block;
                            }
                            </style>
                            
                            <div class="dropdown">
                                <button onclick="toggleDropdown('dropdown1')" class="dropdown-toggle">Câu hỏi thường gặp</button>
                                <div id="dropdown1" class="dropdown-menu">
                                    <a href="#">Làm thế nào để đặt hàng?</a>
                                    <a href="#">Chính sách đổi trả</a>
                                    <a href="#">Thời gian giao hàng</a>
                                </div>
                            </div>
                            
                            <div class="dropdown">
                                <button onclick="toggleDropdown('dropdown2')" class="dropdown-toggle">Phương thức thanh toán</button>
                                <div id="dropdown2" class="dropdown-menu">
                                    <a href="#">Thẻ tín dụng</a>
                                    <a href="#">Chuyển khoản ngân hàng</a>
                                    <a href="#">Thanh toán khi nhận hàng</a>
                                </div>
                            </div>
                            
                            <div class="dropdown">
                                <button onclick="toggleDropdown('dropdown3')" class="dropdown-toggle">Vận chuyển</button>
                                <div id="dropdown3" class="dropdown-menu">
                                    <a href="#">Phí vận chuyển</a>
                                    <a href="#">Thời gian vận chuyển</a>
                                    <a href="#">Khu vực giao hàng</a>
                                </div>
                            </div>
                            
                            <div class="dropdown">
                                <button onclick="toggleDropdown('dropdown4')" class="dropdown-toggle">Tài khoản</button>
                                <div id="dropdown4" class="dropdown-menu">
                                    <a href="#">Đăng ký tài khoản</a>
                                    <a href="#">Quên mật khẩu</a>
                                    <a href="#">Cập nhật thông tin</a>
                                </div>
                            </div>
                            
                            <div class="dropdown">
                                <button onclick="toggleDropdown('dropdown5')" class="dropdown-toggle">Liên hệ</button>
                                <div id="dropdown5" class="dropdown-menu">
                                    <a href="#">Gửi email</a>
                                    <a href="#">Gọi điện thoại</a>
                                    <a href="#">Chat trực tuyến</a>
                                </div>
                            </div>
                            
                            <script>
                            function toggleDropdown(id) {
                                document.getElementById(id).classList.toggle("show");
                            }
                            
                            window.onclick = function(event) {
                                if (!event.target.matches('.dropdown-toggle')) {
                                    var dropdowns = document.getElementsByClassName("dropdown-menu");
                                    for (var i = 0; i < dropdowns.length; i++) {
                                        var openDropdown = dropdowns[i];
                                        if (openDropdown.classList.contains('show')) {
                                            openDropdown.classList.remove('show');
                                        }
                                    }
                                }
                            }
                            </script>
                            
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 smt-30 xmt-30">
                        
                    </div>
                </div>
            </div>
        </section>
        <!-- End Contact Area -->
        <!-- Start Footer Area -->
        <?php include 'templates/footer.php'; ?>
        <!-- Kết thúc khu vực chân trang -->
    </div>
    <!-- Kết thúc wrapper chính của body -->
    <!-- XEM NHANH SẢN PHẨM -->
    <?php include 'templates/quickview_product.php'; ?>
    <!-- END QUICKVIEW PRODUCT -->
    <!-- Placed js at the end of the document so the pages load faster -->
    <script src="js/main.js"></script>

</body>

</html>