<?php
if (isset($_SESSION['success']) && isset($_SESSION['msg'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';

    echo "<div class='alert $class'> {$_SESSION['msg']} </div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}

// Hiển thị lỗi nếu có
if (!empty($_SESSION['errors'])):
?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($_SESSION['errors'] as $value): ?>
                <li> <?= htmlspecialchars($value) ?> </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<!-- Form nhập liệu -->
<form action="<?= BASE_URL_ADMIN . '&action=categories-store' ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" class="form-control" id="name" name="name" 
               value="<?= isset($_SESSION['data']['name']) ? htmlspecialchars($_SESSION['data']['name']) : '' ?>">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="<?= BASE_URL_ADMIN . '&action=categories-index' ?>" class="btn btn-danger">Quay lại danh sách</a>
</form>

<?php
// Xóa dữ liệu nhập cũ sau khi hiển thị để tránh lỗi khi load lại trang
unset($_SESSION['data']);
?>
