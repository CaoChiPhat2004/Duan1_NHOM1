<?php
class CartController {
    public function showCart() {
        require 'views/client/cart.php';
    }

    public function addToCart() {
        session_start();
    
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $price = $_POST['price'] ?? 0;
        $image = $_POST['image'] ?? '';
        $quantity = $_POST['quantity'] ?? 1;
    
        if (!$id) {
            header("Location: index.php");
            exit;
        }
    
        // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
    
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $id,
                'title' => $title,
                'price' => $price,
                'image' => $image,
                'quantity' => $quantity,
            ];
        }
    
        header("Location: index.php?action=cart");
    }
    

    public function updateCart() {
        session_start();

        $index = $_POST['index'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if ($index !== null && isset($_SESSION['cart'][$index])) {
            $_SESSION['cart'][$index]['quantity'] = max(1, intval($quantity));
        }

        header("Location: index.php?action=cart");
    }

    public function removeItem() {
        session_start();

        $index = $_GET['index'] ?? null;

        if ($index !== null && isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reset index
        }

        header("Location: index.php?action=cart");
    }
    public function checkout() {
        require_once 'views/client/checkout.php';
    }
}

