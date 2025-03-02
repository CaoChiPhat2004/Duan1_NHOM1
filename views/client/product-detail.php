<?php
require_once 'models/Shoe.php'; // Load model sản phẩm
require_once dirname(__DIR__, 2) . '/configs/env.php';

// Kiểm tra ID sản phẩm
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Sản phẩm không tồn tại!");
}

$id = intval($_GET['id']); // Lấy ID từ URL

// Lấy thông tin sản phẩm từ database
$productModel = new Shoe();
$product = $productModel->getById($id);

if (!$product) {
    die("Sản phẩm không tồn tại!");
}
?>
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
            <a href="index.php?action=login" >&#128100; Sign In  </a> or  <a href="index.php?action=register">&#128100; Create Account  </a>     
            <a href="index.php?action=cart">&#128717; Cart</a>
        </div>
    </div>
</header>




<!-- End Header -->

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>">Trang Chủ</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#">Sản Phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Giới Thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Liên Hệ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- End Navbar -->




<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm - <?= htmlspecialchars($product['s_title']) ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/detail.css">
</head>
<body>

<div class="container product-container">
    <div class="row">
        <!-- Ảnh sản phẩm -->
        <div class="col-md-6">
            <img src="<?= BASE_ASSETS_UPLOADS . htmlspecialchars($product['s_img_cover']) ?>" 
                 class="product-image"
                 alt="<?= htmlspecialchars($product['s_title']) ?>">
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <p class="text-muted">Home / Product</p>
            <h2 class="product-title"><?= htmlspecialchars($product['s_title']) ?></h2>
            <p class="product-price"><?= number_format($product['s_price'], 0, ',', '.') ?> VNĐ</p>

            <p class="product-description"><?= nl2br(htmlspecialchars($product['s_description'])) ?></p>
            
            <form action="index.php?action=cart-add" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($product['s_id'] ?? '') ?>">
    <input type="hidden" name="title" value="<?= htmlspecialchars($product['s_title'] ?? '') ?>">
    <input type="hidden" name="price" value="<?= htmlspecialchars($product['s_price'] ?? '') ?>">
    <input type="hidden" name="image" value="<?= htmlspecialchars($product['s_img_cover'] ?? '') ?>">

    <!-- Số lượng -->
    <label for="quantity" class="fw-bold">Số lượng:</label>
    <div class="quantity-box">
        <button type="button" onclick="changeQuantity(-1)">-</button>
        <input type="number" name="quantity" id="quantity" value="1" min="1">
        <button type="button" onclick="changeQuantity(1)">+</button>
    </div>

    <!-- Nút thêm vào giỏ hàng -->
    <button type="submit" class="btn btn-custom">🛒 Thêm vào giỏ hàng</button>
</form>

<script>
function changeQuantity(amount) {
    let quantityInput = document.getElementById("quantity");
    let currentValue = parseInt(quantityInput.value) || 1;
    if (currentValue + amount > 0) {
        quantityInput.value = currentValue + amount;
    }
}
</script>




            <a href="index.php" class="btn btn-secondary mt-3 w-100">🔙 Quay lại trang chủ</a>

            <!-- Accordion -->
            <div class="accordion mt-4" id="productDetails">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#info">
                            Thông Tin Sản Phẩm
                        </button>
                    </h2>
                    <div id="info" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            Hãng: Citizen
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#care">
                            Hướng Dẫn Sử Dụng
                        </button>
                    </h2>
                    <div id="care" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            Bảo quản nơi khô ráo, tránh tiếp xúc với nước.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping">
                            Chính Sách Vận Chuyển & Đổi Trả
                        </button>
                    </h2>
                    <div id="shipping" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            Miễn phí vận chuyển với đơn hàng trên 1 triệu VNĐ. Đổi trả trong vòng 7 ngày.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
    function changeQuantity(amount) {
        let quantityInput = document.getElementById('quantity');
        let currentValue = parseInt(quantityInput.value);
        if (!isNaN(currentValue)) {
            let newValue = currentValue + amount;
            if (newValue < 1) newValue = 1;
            quantityInput.value = newValue;
        }
    }
</script>
</body>
</html>



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
