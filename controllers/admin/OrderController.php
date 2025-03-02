<?php
require_once __DIR__ . "/../../models/Order.php";
require_once __DIR__ . "/../../models/Shoe.php";


class OrderController {
    private $orderModel;
    private $shoeModel;

    public function __construct() {
        $this->orderModel = new Order();
        $this->shoeModel = new Shoe();
    }

    // 📌 Danh sách đơn hàng
    public function index() {
        $view = 'orders/index';
        $title = 'Danh sách Đơn Hàng';
        $orders = $this->orderModel->getAllOrders();
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // 📌 Hiển thị chi tiết đơn hàng
    public function show() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['msg'] = '⚠️ Thiếu hoặc sai ID!';
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit();
        }

        $id = intval($_GET['id']);
        $order = $this->orderModel->getOrderById($id);

        if (!$order) {
            $_SESSION['msg'] = "🚫 Đơn hàng không tồn tại!";
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit();
        }

        $view = 'orders/show';
        $title = "Chi tiết Đơn Hàng #$id";
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // 📌 Hiển thị form chỉnh sửa đơn hàng
    public function edit() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['msg'] = '⚠️ Thiếu hoặc sai ID!';
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit();
        }
    
        $id = intval($_GET['id']);
        $order = $this->orderModel->getOrderById($id);
    
        if (!$order) {
            $_SESSION['msg'] = "🚫 Đơn hàng không tồn tại!";
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit();
        }
    
        // ✅ Kiểm tra lại dữ liệu lấy ra
        // echo '<pre>'; print_r($order); echo '</pre>'; exit(); 
    
        $view = 'orders/edit';
        $title = "Chỉnh sửa Đơn Hàng #$id";
        require_once PATH_VIEW_ADMIN_MAIN;
    }
    

    // 📌 Cập nhật đơn hàng
    public function update() {
        if (!isset($_POST['id'], $_POST['status'], $_POST['payment_status'], $_POST['quantity'])) {
            $_SESSION['msg'] = '⚠️ Dữ liệu không hợp lệ!';
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit();
        }

        $id = intval($_POST['id']);
        $status = htmlspecialchars($_POST['status']);
        $payment_status = htmlspecialchars($_POST['payment_status']);
        $quantity = intval($_POST['quantity']);

        // Kiểm tra số lượng hợp lệ
        if ($quantity <= 0) {
            $_SESSION['msg'] = "⚠️ Số lượng phải lớn hơn 0!";
            header('Location: ' . BASE_URL_ADMIN . "&action=orders-edit&id=$id");
            exit();
        }

        // Kiểm tra đơn hàng tồn tại
        $order = $this->orderModel->getOrderById($id);
        if (!$order) {
            $_SESSION['msg'] = "🚫 Đơn hàng không tồn tại!";
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit();
        }

        // Lấy giá sản phẩm để tính tổng giá trị mới
        $total_price = $order['shoe_price'] * $quantity;

        // Cập nhật đơn hàng
        if ($this->orderModel->updateOrder($id, $status, $payment_status, $quantity)) {
            $_SESSION['msg'] = "✅ Cập nhật đơn hàng thành công! Giá mới: $" . number_format($total_price, 2);
        } else {
            $_SESSION['msg'] = "🚫 Cập nhật thất bại!";
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
        exit();
    }

    // 📌 Xóa đơn hàng
    public function delete()
    {
        if (isset($_GET['id'])) {
            $orderId = $_GET['id'];
    
            $orderModel = new Order();
            $result = $orderModel->deleteOrder($orderId); // Xóa đơn hàng
    
            if ($result) {
                $_SESSION['success'] = "Xóa đơn hàng thành công!";
            } else {
                $_SESSION['error'] = "Xóa đơn hàng thất bại!";
            }
        } else {
            $_SESSION['error'] = "Không tìm thấy ID đơn hàng!";
        }
    
        // Chuyển hướng về trang danh sách đơn hàng trong Admin (KHÔNG về Client)
        header("Location: " . BASE_URL_ADMIN . "&action=orders-index");
        exit();
    }
    
    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'] ?? '';
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $user_id = $_SESSION['user_id'] ?? 0;
            $payment_status = 'unpaid';
            $status = 'pending';
    
            if (!$fullname || !$address || !$phone) {
                die("Vui lòng nhập đầy đủ thông tin!");
            }
    
            // Gọi model để lưu đơn hàng
            $orderModel = new OrderModel();
            $order_id = $orderModel->createOrder($user_id, $fullname, $address, $phone, $status, $payment_status);
    
            if ($order_id) {
                // Chuyển hướng về trang chủ thay vì JS redirect
                header("Location: ?action=home");
                exit();
            } else {
                die("Lỗi khi tạo đơn hàng.");
            }
        }
    }
    public function orderHistory() {
        $orderModel = new Order();  // Khởi tạo đối tượng Order
        $orders = $orderModel->getAllOrders();  // Lấy tất cả đơn hàng
    
        include "views/client/order_history.php"; 
    }
    
    public function orderDetail() {
        if (!isset($_GET['id'])) {
            die("Thiếu ID đơn hàng!");
        }
    
        $id = $_GET['id'];
        $orderModel = new Order();
        $order = $orderModel->getOrderById($id);
    
        if (!$order) {
            die("Đơn hàng không tồn tại!");
        }
    
        include "views/client/order_detail.php";
    }
}
    
    


