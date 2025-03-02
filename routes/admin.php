<?php
$action = $_GET['action'] ?? '/';

if (
    empty($_SESSION['user'])
    && !in_array($action, ['show-form-login', 'login'])
) {
    header('Location: ' . BASE_URL_ADMIN . '&action=show-form-login');
    exit();
}

try {
    match ($action) {
        '/'         => (new DashboardController)->index(),
        'test-show' => (new TestController)->show(),

        'show-form-login'       => (new AuthenController)->showFormLogin(),
        'login'                 => (new AuthenController)->login(),
        'logout'                => (new AuthenController)->logout(),

        // CRUD User
        'users-index'    => (new UserController)->index(),
        'users-show'     => (new UserController)->show(),
        'users-create'   => (new UserController)->create(),
        'users-store'    => (new UserController)->store(),
        'users-edit'     => (new UserController)->edit(),
        'users-update'   => (new UserController)->update(),
        'users-delete'   => (new UserController)->delete(),

        // CRUD Shoe
        'shoes-index'    => (new ShoeController)->index(),
        'shoes-show'     => (new ShoeController)->show(),
        'shoes-create'   => (new ShoeController)->create(),
        'shoes-store'    => (new ShoeController)->store(),
        'shoes-edit'     => (new ShoeController)->edit(),
        'shoes-update'   => (new ShoeController)->update(),
        'shoes-delete'   => (new ShoeController)->delete(),

        // CRUD Order
        'orders-index'    => (new OrderController)->index(),
        'orders-show'     => (new OrderController)->show(),
        'orders-edit'     => (new OrderController)->edit(),  // ✅ Thêm dòng này để xử lý Edit
        'orders-update'   => (new OrderController)->update(),
        'orders-delete'   => (new OrderController)->delete(),


        // 🔥 Thêm route xử lý Category
        'categories-index'  => (new CategoryController)->index(),
        'categories-show'   => (new CategoryController)->show(),
        'categories-create' => (new CategoryController)->create(),
        'categories-store'  => (new CategoryController)->store(),
        'categories-edit'   => (new CategoryController)->edit(),
        'categories-update' => (new CategoryController)->update(),
        'categories-delete' => (new CategoryController)->delete(),

        default => throw new Exception("Unhandled action: $action"),
    };
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    header("HTTP/1.0 404 Not Found");
    exit();
}


 
