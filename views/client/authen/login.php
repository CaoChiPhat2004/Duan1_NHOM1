<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="./assets/css/banner.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/shoe.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        .carousel-item img { height: 400px; object-fit: cover; }
        .product-card img { height: 200px; object-fit: cover; }
        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background: #f8f9fa;
        }
        .search-box {
            display: flex;
            align-items: center;
            background: #eee;
            border-radius: 30px;
            padding: 5px 15px;
            flex-grow: 1;
            max-width: 500px;
        }
        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            flex-grow: 1;
        }
        .user-actions {
            display: flex;
            gap: 15px;
        }


.banner {
    background-image: url('path/to/image.jpg');
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
    width: 100%;
    height: 500px; /* Đặt chiều cao cố định */
}



    </style>

</head>
<body>
  <!-- Header -->
  <header>
    <div class="header-top">
        <a href="index.php"><img src="assets/uploads/logo/logo.png" alt="Logo" height="50"></a>
        
        <!-- Search Box -->
        <form action="index.php" method="GET" class="search-box">
            <input type="hidden" name="action" value="search">
            <input type="text" name="q" placeholder="Search on sneaker store..." required>
            <button type="submit">&#128269;</button>
        </form>

        <div class="user-actions">
            <?php
           
            if (isset($_SESSION['user'])) {
                // Nếu đã đăng nhập, hiển thị tên và nút đăng xuất
                echo '<span>👤 ' . htmlspecialchars($_SESSION['user']['email']) . '</span>';
                echo ' | <a href="index.php?action=logout">🚪 Đăng xuất</a>';
            } else {
                // Nếu chưa đăng nhập, hiển thị Đăng nhập / Đăng ký
                echo '<a href="index.php?action=login">&#128100; Đăng nhập</a> hoặc  
                      <a href="index.php?action=register">&#128100; Tạo tài khoản</a>';
            }
            ?>
            <a href="index.php?action=cart">&#128717; Cart</a>
            <a href="index.php?action=order_history">🛒 Order History</a>
        </div>
    </div>
</header>




<!-- End Header -->

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>">Trang Chủ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php?action=products">Sản Phẩm</a></li>

                <li class="nav-item"><a class="nav-link" href="index.php?action=contact">Giới Thiệu</a></li>

                <li class="nav-item"><a class="nav-link" href="#">Liên Hệ</a></li>
            </ul>
        </div>
    </div>
</nav>


    <!-- End Navbar -->

<form action="index.php?action=process-login" method="POST">
    <h2>Đăng Nhập</h2>
    Email: <input type="email" name="email" required>
    Mật khẩu: <input type="password" name="password" required>
    <button type="submit">Đăng Nhập</button>
</form>
<p>Chưa có tài khoản? <a href="index.php?action=register">Đăng ký</a></p>


<!--Footer ---->
<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row">
            <!-- About -->
            <div class="col-lg-3 col-md-6">
                <h5 class="fw-bold">ABOUT</h5>
                <p>Thông tin chi tiết xin liên hệ phatccph45456@fpt.edu.vn và những dịch vụ được hỗ trợ</p>
                <div class="payment-icons">
                    <img src="assets/uploads/footer/cards.png" alt="Cards" >
                    <img src="assets/uploads/footer/mastercart.png" alt="MasterCard">
                    <img src="assets/uploads/footer/paypal.png" alt="PayPal">
                </div>
            </div>

            <!-- Questions -->
            <div class="col-lg-3 col-md-6">
                <h5 class="fw-bold">QUESTIONS</h5>
                <ul class="list-unstyled">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Track Orders</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="#">Jobs</a></li>
                    <li><a href="#">Shipping</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>

            <!-- Latest News -->
            <div class="col-lg-3 col-md-6">
                <h5 class="fw-bold">QUESTIONS</h5>
                <div class="footer-news">
                    <div class="news-item d-flex align-items-center mb-2">
                        <img src="assets/uploads/banner/bg.jpg" class="me-2" width="60" alt="News">
                        <div>
                            <small>1/4, 2024</small>
                            <p class="mb-0"><a href="#">COMMERCIAL SNEAKER</a></p>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <div class="news-item d-flex align-items-center">
                        <img src="assets/uploads/banner/bg-2.jpg" class="me-2" width="60" alt="News">
                        <div>
                            <small>1/4, 2024</small>
                            <p class="mb-0"><a href="#">TRENDS THIS YEAR</a></p>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="col-lg-3 col-md-6">
                <h5 class="fw-bold">QUESTIONS</h5>
                <p><strong>C.</strong> Your Company Ltd</p>
                <p><strong>B.</strong> FPT Polytechnic, 13 P. Trịnh Văn Bô, Xuân Phương, Hà Nội, Việt Nam</p>
                <p><strong>T.</strong> 0325916627</p>
                <p><strong>E.</strong> <a href="mailto:phatcph45456@fpt.edu.vn">phatcph45456@fpt.edu.vn</a></p>
            </div>
        </div>

        <hr class="my-4 border-secondary">

        <!-- Social Media -->
        <div class="text-center mb-3">
            <a href="#" class="me-3"><i class="fab fa-instagram"></i> INSTAGRAM</a>
            <a href="#" class="me-3"><i class="fab fa-google-plus"></i> G+PLUS</a>
            <a href="#" class="me-3"><i class="fab fa-pinterest"></i> PINTEREST</a>
            <a href="#" class="me-3"><i class="fab fa-facebook"></i> FACEBOOK</a>
            <a href="#" class="me-3"><i class="fab fa-twitter"></i> TWITTER</a>
            <a href="#" class="me-3"><i class="fab fa-youtube"></i> YOUTUBE</a>
            <a href="#"><i class="fab fa-tumblr"></i> TUMBLR</a>
        </div>

        <!-- Copyright -->
        <div class="text-center">
            <p>Copyright &copy; 2025 All rights reserved | This template is made with ❤️ by Team 1 – Duan1</p>
        </div>
    </div>
</footer>

 <!-- End Footer ---->
</body>
</html>
