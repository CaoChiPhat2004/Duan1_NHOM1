<?php

$action = $_GET['action'] ?? '/';
$id = $_GET['id'] ?? null;

$shoeController = new ShoeController();
$cartController = new CartController();
$homeController = new HomeController();
$orderController = new OrderController();

match ($action) {
    '/'             => $homeController->index(),
    'home'          => $homeController->index(),
    'search'        => $shoeController->search(),
    'product-detail' => $id ? $shoeController->detail($id) : $homeController->index(),
    'cart'          => $cartController->showCart(),
    'cart-add'      => $cartController->addToCart(),
    'cart-update'   => $cartController->updateCart(),
    'cart-remove'   => $cartController->removeItem(),
    'products'      => $shoeController->list(),
    'category'      => $id ? $shoeController->category($id) : $homeController->index(),
    'checkout'      => $cartController->checkout(), 
    'process-order' => $orderController->processOrder(),
    
    // Route cho trang Order History
    'order_history' => $orderController->orderHistory(),
     'order-detail' => $orderController->orderDetail(),


    default         => $homeController->index()
};


