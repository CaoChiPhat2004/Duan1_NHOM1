<?php
session_start();
include 'configs/env.php';

// Kiểm tra nếu giỏ hàng trống
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Giỏ hàng trống!'); window.location.href = 'cart.php';</script>";
    exit;
}

// Giả sử người dùng đã đăng nhập
$user_id = $_SESSION['user_id'] ?? 1; // Mặc định user_id = 1 nếu chưa có đăng nhập
$payment_status = 'paid'; // Thanh toán thành công
$order_status = 'pending'; // Đơn hàng mặc định chờ xử lý

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
    $pdo->beginTransaction();

    // Lấy dữ liệu từ giỏ hàng
    $cart = $_SESSION['cart'];
    foreach ($cart as $item) {
        $shoe_id = $item['id'];
        $quantity = $item['quantity'];

        // Lưu vào bảng orders
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, shoe_id, quantity, status, payment_status, created_at) 
                               VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id, $shoe_id, $quantity, $order_status, $payment_status]);
    }

    // Xóa giỏ hàng sau khi thanh toán thành công
    unset($_SESSION['cart']);

    $pdo->commit();
    echo "<script>alert('Thanh toán thành công! Đơn hàng đã được lưu.'); window.location.href = 'order_success.php';</script>";

} catch (Exception $e) {
    $pdo->rollBack();
    die("Lỗi khi thanh toán: " . $e->getMessage());
}
?>

