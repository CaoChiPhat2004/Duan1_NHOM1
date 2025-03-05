<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'models/Order.php';

class CheckoutController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    public function index() {
        // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=authen&action=showLoginForm&redirect=checkout");
            exit;
        }

        include_once './views/client/checkout.php';
    }

    public function processOrder() {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!isset($_SESSION['user']) || empty($_SESSION['user']['id'])) {
            echo "<script>alert('Vui lòng đăng nhập để thanh toán!'); window.location.href = 'index.php?action=login';</script>";
            exit;
        }

        // Kiểm tra nếu giỏ hàng trống
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo "<script>alert('Giỏ hàng trống! Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.'); window.location.href = '?action=cart';</script>";
            exit;
        }

        // Lấy thông tin người dùng từ session
        $user_id = $_SESSION['user']['id'];
        $fullname = trim($_POST['fullname'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $payment_status = $_POST['payment_status'] ?? 'unpaid';

        // Kiểm tra nếu thông tin người nhận hàng bị thiếu
        if (empty($fullname) || empty($address) || empty($phone)) {
            echo "<script>alert('Vui lòng điền đầy đủ thông tin giao hàng!'); window.location.href = '?action=checkout';</script>";
            exit;
        }

        // Bước 1: Thêm đơn hàng vào bảng `orders` và nhận ID của đơn hàng
        $order_id = $this->orderModel->createOrder($user_id, $payment_status);

        if ($order_id) {
            // Bước 2: Cập nhật thông tin giao hàng vào bảng `orders`
            $sql = "UPDATE orders SET fullname = :fullname, address = :address, phone = :phone WHERE id = :order_id";
            $result = $this->orderModel->query($sql, [
                'fullname' => $fullname,
                'address' => $address,
                'phone' => $phone,
                'order_id' => $order_id
            ]);

            if (!$result) {
                echo "<script>alert('Lỗi khi cập nhật thông tin giao hàng. Vui lòng thử lại!'); window.location.href = '?action=checkout';</script>";
                exit;
            }

            // Bước 3: Thêm từng sản phẩm từ giỏ hàng vào bảng `order_items`
            foreach ($_SESSION['cart'] as $item) {
                $shoe_id = $item['id'];
                $quantity = $item['quantity'];

                // Thêm sản phẩm vào order_items
                $result = $this->orderModel->addOrderItem($order_id, $shoe_id, $quantity);

                if (!$result) {
                    echo "<script>alert('Lỗi khi thêm sản phẩm vào đơn hàng. Vui lòng thử lại!'); window.location.href = '?action=checkout';</script>";
                    exit;
                }
            }

            // Bước 4: Xóa giỏ hàng sau khi đặt hàng thành công
            unset($_SESSION['cart']);

            // Chuyển hướng đến trang cảm ơn sau khi thành công
            echo "<script>alert('Đặt hàng thành công! Cảm ơn bạn đã mua sắm.'); window.location.href = 'order_success.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi tạo đơn hàng. Vui lòng thử lại!'); window.location.href = '?action=checkout';</script>";
        }
    }
}
?>
