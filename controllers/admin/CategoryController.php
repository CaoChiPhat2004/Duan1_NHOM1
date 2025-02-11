<?php

class CategoryController
{
    private $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    // Hiển thị danh sách
    public function index()
    {
        $view = 'categories/index';
        $title = 'Danh sách danh mục';
        $data = $this->category->select('*', '1 = 1 ORDER BY id DESC');

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // Hiển thị chi tiết theo ID
    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id"', 99);
            }

            $id = $_GET['id'];

            
            $category = $this->category->find('*', 'id = :id', ['id' => $id]);
            if (empty($category)) {
                throw new Exception("Danh mục có ID = $id KHÔNG TỒN TẠI!");
            }

            $view = 'categories/show';
            $title = "Chi tiết danh mục có ID = $id";

            require_once PATH_VIEW_ADMIN_MAIN;
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
            exit();
        }
    }

    // Hiển thị form thêm mới
    public function create()
    {
        $view = 'categories/create';
        $title = 'Thêm mới danh mục';
       

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // Lưu dữ liệu thêm mới
    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Yêu cầu phương thức phải là POST');
            }

            $data = $_POST + $_FILES;

            $_SESSION['errors'] = [];

            // Validate dữ liệu
            if (empty($data['name']) || strlen($data['name']) > 50) {
                $_SESSION['errors']['name'] = 'Trường name bắt buộc và độ dài không quá 50 ký tự.';
            }

            $rowCount = $this->category->insert($data);

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Thao tác thành công!';
            } else {
                throw new Exception('Thao tác KHÔNG thành công!');
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=categories-create');
        exit();
    }

    // Hiển thị form cập nhật theo ID
    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id"', 99);
            }

            $id = $_GET['id'];

            $user = $this->category->find('*', 'id = :id', ['id' => $id]);

            if (empty($category)) {
                throw new Exception("User có ID = $id KHÔNG TỒN TẠI!");
            }

            $view = 'categories/edit';
            $title = "Cập nhật User có ID = $id";

            require_once PATH_VIEW_ADMIN_MAIN;
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
            exit();
        }
    }

    // Lưu dữ liệu cập nhật theo ID
    public function update()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Yêu cầu phương thức phải là POST');
            }

            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id"', 99);
            }

            $id = $_GET['id'];

            $category = $this->category->find('*', 'id = :id', ['id' => $id]);

            if (empty($category)) {
                throw new Exception("Danh mục có ID = $id KHÔNG TỒN TẠI!");
            }

            $data = $_POST + $_FILES;

            $_SESSION['errors'] = [];

            // Validate dữ liệu
            if (empty($data['name']) || strlen($data['name']) > 50) {
                $_SESSION['errors']['name'] = 'Trường name bắt buộc và độ dài không quá 50 ký tự.';
            }

           
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage() . ' - Line: ' . $th->getLine();

            if ($th->getCode() == 99) {
                header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
                exit();
            }
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=categories-edit&id=' . $id);
        exit();
    }

    // Xóa dữ liệu theo ID
    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id"', 99);
            }

            $id = $_GET['id'];

            $category = $this->category->find('*', 'id = :id', ['id' => $id]);

            if (empty($category)) {
                throw new Exception("User có ID = $id KHÔNG TỒN TẠI!");
            }

            $rowCount = $this->category->delete('id = :id', ['id' => $id]);

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=categories-index');
        exit();
    }
}
