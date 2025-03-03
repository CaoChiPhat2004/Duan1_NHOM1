<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'configs/env.php'; // Kết nối database

// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Giỏ hàng trống!'); window.location.href = 'cart.php';</script>";
    exit;
}

$cart = $_SESSION['cart'];
$total_price = 0;

foreach ($cart as $item) {
    $total_price += (isset($item['price']) ? $item['price'] : 0) * (isset($item['quantity']) ? $item['quantity'] : 1);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Checkout</h2>

    <form action="?action=process-order" method="POST">


        <!-- Thông tin giao hàng -->
        <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" name="fullname" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <!-- Phương thức thanh toán -->
        <div class="mb-3">
            <label class="form-label">Phương thức thanh toán</label>
            <select name="payment_status" class="form-control">
                <option value="unpaid">Thanh toán khi nhận hàng</option>
                <option value="paid">Thanh toán online</option>
            </select>
        </div>

        <!-- Giỏ hàng -->
        <h4>Giỏ hàng</h4>
        <ul class="list-group mb-3">
            <?php foreach ($cart as $index => $item): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <div>
                        <strong><?= isset($item['title']) ? htmlspecialchars($item['title']) : 'Sản phẩm không xác định' ?></strong> 
                        (x<?= isset($item['quantity']) ? (int)$item['quantity'] : 1 ?>)
                    </div>
                    <span><?= isset($item['price']) ? number_format($item['price'] * $item['quantity'], 0, ',', '.') : '0' ?> VND</span>
                </li>

                <!-- Lưu ID sản phẩm và số lượng để xử lý -->
                <input type="hidden" name="cart[<?= $index ?>][id]" value="<?= $item['id'] ?>">
                <input type="hidden" name="cart[<?= $index ?>][quantity]" value="<?= $item['quantity'] ?>">
            <?php endforeach; ?>

            <li class="list-group-item d-flex justify-content-between">
                <strong>Tổng cộng</strong>
                <strong><?= number_format($total_price, 0, ',', '.') ?> VND</strong>
            </li>
        </ul>

        <button type="submit" class="btn btn-primary w-100">Đặt hàng</button>
    </form>
</div>

</body>
</html>

