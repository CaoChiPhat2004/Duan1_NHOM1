<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';

    echo "<div class='alert $class'> {$_SESSION['msg']} </div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>


<form action="<?= BASE_URL_ADMIN . '&action=categories-update&id=' . $shoe['s_id'] ?>" method="post" enctype="multipart/form-data">
    < class="mb-3 mt-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $categories['s_title'] ?>">
</div>
    <button type="submit" class="btn btn-primary">Submit</button>

    <a href="<?= BASE_URL_ADMIN . '&action=categories-index' ?>" class="btn btn-danger">Quay lại danh sách</a>
</form>