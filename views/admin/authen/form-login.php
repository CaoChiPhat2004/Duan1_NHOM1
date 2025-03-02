<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';

    echo "<div class='alert $class alert-dismissible fade show' role='alert'> {$_SESSION['msg']} 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <h3 class="card-title text-center mb-4">Login</h3>
        <form action="<?= BASE_URL_ADMIN . '&action=login' ?>" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="text-center">
                <a href="<?= BASE_URL_ADMIN . '&action=forgot-password' ?>" class="text-muted">Forgot your password?</a>
            </div>
        </form>
    </div>
</div>
