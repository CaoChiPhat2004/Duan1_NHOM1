<a href="<?= BASE_URL_ADMIN . '&action=categories-create' ?>" class="btn btn-lg btn-primary mb-4">Thêm mới</a>

<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class alert-dismissible fade show' role='alert'> {$_SESSION['msg']} 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
    unset($_SESSION['success'], $_SESSION['msg']);
}
?>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th width="10%">ID</th>
                <th width="60%">Tên Danh Mục</th>
                <th width="30%" class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $category): ?>
                    <tr>
                        <td><?= htmlspecialchars($category['id']) ?></td>
                        <td><?= htmlspecialchars($category['name']) ?></td>
                        <td class="text-center">
                            <a href="<?= BASE_URL_ADMIN . '&action=categories-show&id=' . $category['id'] ?>" class="btn btn-sm btn-info me-2">Xem</a>
                            <a href="<?= BASE_URL_ADMIN . '&action=categories-edit&id=' . $category['id'] ?>" class="btn btn-sm btn-warning me-2">Sửa</a>
                            <a href="<?= BASE_URL_ADMIN . '&action=categories-delete&id=' . $category['id'] ?>" onclick="return confirm('Có chắc chắn muốn xóa danh mục này không?')" class="btn btn-sm btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Không có danh mục nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
