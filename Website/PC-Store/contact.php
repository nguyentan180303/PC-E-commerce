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
            <?php include 'templates/offsetmenu.php'; ?>
            <!-- End Offset MEnu -->
            <!-- Start Cart Panel -->
            <div class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="shp__cart__wrap">
                        <div class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="#">
                                    <img src="images/product/sm-img/1.jpg" alt="hình ảnh sản phẩm">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="product-details.html">Loa không dây BO&Play</a></h2>
                                <span class="quantity">SL: 1</span>
                                <span class="shp__price">105.000đ</span>
                            </div>
                            <div class="remove__btn">
                                <a href="#" title="Xóa mục này"><i class="zmdi zmdi-close"></i></a>
                            </div>
                        </div>
                        <div class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="#">
                                    <img src="images/product/sm-img/2.jpg" alt="hình ảnh sản phẩm">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="product-details.html">Nến Brone</a></h2>
                                <span class="quantity">SL: 1</span>
                                <span class="shp__price">25.000đ</span>
                            </div>
                            <div class="remove__btn">
                                <a href="#" title="Xóa mục này"><i class="zmdi zmdi-close"></i></a>
                            </div>
                        </div>
                    </div>
                    <ul class="shoping__total">
                        <li class="subtotal">Tổng phụ:</li>
                        <li class="total__price">130.000đ</li>
                    </ul>
                    <ul class="shopping__btn">
                        <li><a href="cart.html">Xem giỏ hàng</a></li>
                        <li class="shp__checkout"><a href="checkout.html">Thanh toán</a></li>
                    </ul>
                </div>
            </div>
            <!-- Kết thúc Bảng điều khiển giỏ hàng -->
        </div>
        <!-- Kết thúc Offset Wrapper -->
        <!-- Bắt đầu khu vực Bradcaump -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Liên hệ chúng tôi</h2>
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" href="index.html">Trang chủ</a>
                                    <span class="brd-separetor">/</span>
                                    <span class="breadcrumb-item active">Liên hệ chúng tôi</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc khu vực Bradcaump -->
        <!-- Bắt đầu khu vực Liên hệ -->
        <section class="htc__contact__area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="htc__contact__container">
                            <div class="htc__contact__address">
                                <h2 class="contact__title">Thông tin liên hệ</h2>
                                <div class="contact__address__inner">
                                    <!-- Bắt đầu Địa chỉ đơn -->
                                    <div class="single__contact__address">
                                        <div class="contact__icon">
                                            <span class="ti-location-pin"></span>
                                        </div>
                                        <div class="contact__details">
                                            <p>Địa chỉ : <br>Hồ Chí Minh, Việt Nam.</p>
                                        </div>
                                    </div>
                                    <!-- Kết thúc Địa chỉ đơn -->
                                </div>
                                <div class="contact__address__inner">
                                    <!-- Bắt đầu Địa chỉ đơn -->
                                    <div class="single__contact__address">
                                        <div class="contact__icon">
                                            <span class="ti-mobile"></span>
                                        </div>
                                        <div class="contact__details">
                                            <p> Điện thoại : <br><a href="#">+84 123 456 789 </a></p>
                                        </div>
                                    </div>
                                    <!-- Kết thúc Địa chỉ đơn -->
                                    <!-- Bắt đầu Địa chỉ đơn -->
                                    <div class="single__contact__address">
                                        <div class="contact__icon">
                                            <span class="ti-email"></span>
                                        </div>
                                        <div class="contact__details">
                                            <p> Thư điện tử :<br><a href="#">info@example.com</a></p>
                                        </div>
                                    </div>
                                    <!-- Kết thúc Địa chỉ đơn -->
                                </div>
                            </div>
                            <div class="contact-form-wrap">
                                <div class="contact-title">
                                    <h2 class="contact__title">Liên hệ với chúng tôi</h2>
                                </div>
                                <form id="contact-form" action="mail.php" method="post">
                                    <div class="single-contact-form">
                                        <div class="contact-box name">
                                            <input type="text" name="name" placeholder="Tên của bạn*">
                                            <input type="email" name="email" placeholder="Thư điện tử*">
                                        </div>
                                    </div>
                                    <div class="single-contact-form">
                                        <div class="contact-box subject">
                                            <input type="text" name="subject" placeholder="Chủ đề*">
                                        </div>
                                    </div>
                                    <div class="single-contact-form">
                                        <div class="contact-box message">
                                            <textarea name="message" placeholder="Tin nhắn*"></textarea>
                                        </div>
                                    </div>
                                    <div class="contact-btn">
                                        <button type="submit" class="fv-btn">GỬI</button>
                                    </div>
                                </form>
                            </div>
                            <div class="form-output">
                                <p class="form-messege"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 smt-30 xmt-30">
                        <div class="map-contacts">
                            <div id="googleMap"></div>
                        </div>
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
    <?php include 'templates/quickview_product.php'; ?>
    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="js/vendor/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>

    <!-- Google Map js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmGmeot5jcjdaJTvfCmQPfzeoG_pABeWo"></script>
    <script>
        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            // Basic options for a simple Google Map
            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
            var mapOptions = {
                // How zoomed in you want the map to start at (always required)
                zoom: 12,

                scrollwheel: false,

                // The latitude and longitude to center the map (always required)
                center: new google.maps.LatLng(23.7286, 90.3854), // New York

                // How you would like to style the map. 
                // This is where you would paste any style found on Snazzy Maps.
                styles: [


                    {
                        "featureType": "administrative",
                        "elementType": "all",
                        "stylers": [{
                            "hue": "#ff0000"
                        }]
                    },
                    {
                        "featureType": "administrative",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#888888"
                        }]
                    },
                    {
                        "featureType": "administrative",
                        "elementType": "geometry.fill",
                        "stylers": [{
                            "hue": "#ff0000"
                        }]
                    },
                    {
                        "featureType": "administrative",
                        "elementType": "labels.text",
                        "stylers": [{
                                "color": "#6e6e6e"
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.country",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#6f6b6b"
                        }]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "labels.text",
                        "stylers": [{
                            "color": "#c5c5c5"
                        }]
                    },
                    {
                        "featureType": "landscape.natural",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#cfcfcf"
                        }]
                    },
                    {
                        "featureType": "landscape.natural.landcover",
                        "elementType": "all",
                        "stylers": [{
                            "hue": "#ff0000"
                        }]
                    },
                    {
                        "featureType": "landscape.natural.landcover",
                        "elementType": "geometry",
                        "stylers": [{
                            "hue": "#ff0000"
                        }]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text",
                        "stylers": [{
                                "visibility": "off"
                            },
                            {
                                "color": "#909090"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.icon",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    },
                    {
                        "featureType": "poi.medical",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#e5e5e5"
                        }]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#e5e5e5"
                        }]
                    },
                    {
                        "featureType": "poi.place_of_worship",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#ff0000"
                        }]
                    },
                    {
                        "featureType": "poi.sports_complex",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#f7f7f7"
                        }]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry.fill",
                        "stylers": [{
                            "color": "#ffffff"
                        }]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry.stroke",
                        "stylers": [{
                            "gamma": 7.18
                        }]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.icon",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "labels.text",
                        "stylers": [{
                            "visibility": "simplified"
                        }]
                    },
                    {
                        "featureType": "transit.line",
                        "elementType": "geometry",
                        "stylers": [{
                            "gamma": 0.48
                        }]
                    },
                    {
                        "featureType": "transit.station",
                        "elementType": "labels.icon",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    },
                    {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [{
                                "color": "#bcbcbc"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels.text.fill",
                        "stylers": [{
                            "color": "#ffffff"
                        }]
                    }
                ]
            };

            // Get the HTML DOM element that will contain your map 
            // We are using a div with id="map" seen below in the <body>
            var mapElement = document.getElementById('googleMap');

            // Create the Google Map using our element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);

            // Let's also add a marker while we're at it
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(23.7286, 90.3854),
                map: map,
                title: 'Tasfiu!',
                icon: 'images/icons/map.png',
                animation: google.maps.Animation.BOUNCE

            });
        }
    </script>


    <!-- Waypoints.min.js. -->
    <script src="js/waypoints.min.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>

</body>

</html>