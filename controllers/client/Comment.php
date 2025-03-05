<?php

// Xử lý bình luận trong controller hoặc script PHP của bạn
if (isset($_POST['comment'])) {
    $product_id = $_POST['product_id'];
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $comment = nl2br(htmlspecialchars($_POST['comment']));

    // Giả sử bạn có một hàm để lưu bình luận vào cơ sở dữ liệu
    saveComment($product_id, $name, $email, $comment);
}

// Hàm lưu bình luận vào cơ sở dữ liệu
function saveComment($product_id, $name, $email, $comment) {
    // Kết nối với database và lưu bình luận
    // Ví dụ sử dụng PDO:
    global $pdo;
    $sql = "INSERT INTO comments (product_id, name, email, comment) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id, $name, $email, $comment]);
}

// Lấy danh sách bình luận từ database
function getComments($product_id) {
    global $pdo;
    $sql = "SELECT name, email, comment FROM comments WHERE product_id = ? ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy bình luận sản phẩm khi trang được tải
$comments = getComments($product['s_id']);
