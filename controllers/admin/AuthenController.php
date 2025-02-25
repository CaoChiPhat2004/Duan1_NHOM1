<?php

use Rakit\Validation\Validator;

class AuthenController
{
    protected $connection;
    protected $table;
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }
    public function validate($validator, $data, $rules)
    {
        $validation = $validator->make($data, $rules);

        // then validate
        $validation->validate();

        if ($validation->fails()) {
            return $validation->errors()->firstOfAll();
        }

        return [];
    }
    public function showFormLogin()
    {
        $view = 'authen/form-login';
        $title = 'Đăng nhập';

        require_once PATH_VIEW_ADMIN_MAIN;
    }
    public function checkExistsEmailForCreate($email)
    {
        $queryBuilder = $this->connection->createQueryBuilder();


        $queryBuilder->select('COUNT(*)')
            ->from($this->table)
            ->where('email = :email')
            ->setParameter('email', $email);

        $result = $queryBuilder->fetchOne();


        return $result > 0;
    }
    public function logError($message)
    {
        $date = date('d-m-Y');

        $message = date('d-m-Y H:i:s') . ' - ' . $message . PHP_EOL;

        // Type: 3 - Ghi vào file
        error_log($message, 3, "storage/logs/$date.log");
    }
    public function login()
    {
        try {
            $data = $_POST;
            $validator = new Validator;
            $errors = $this->validate(
                $validator,
                $data,
                [
                    'email'    => ['required', 'email'],
                    'password' => 'required|min:6|max:30',
                ]
            );
            $user = $this->user->getUserByEmail($data['email']);
            $checkPass = password_verify($data['password'], $user['password'] ?? null);

            if (!empty($errors) || empty($user) || !$checkPass) {
                $_SESSION['status']     = false;
                $_SESSION['msg']        = 'Thao tác KHÔNG thành công!';
                $_SESSION['data']       = $_POST;
                $_SESSION['errors']     = $errors;

                if (empty($user) && !isset($_SESSION['errors']['email'])) {
                    $_SESSION['errors']['email'] = 'Email does not exist!';
                }
                if (isset($user['password']) && !$checkPass && !isset($_SESSION['errors']['password'])) {
                    $_SESSION['errors']['verify'] = 'Incorrect password!';
                }
                redirect('/authen');
            } else {
                $_SESSION['data'] = null;
            }
            $_SESSION['user'] = $user;

            $redirectTo = ($_SESSION['user']['type'] == 'admin') ? '/admin' : '/';
            redirect($redirectTo);
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
            $_SESSION['data'] = $_POST;

            redirect('/authen');
        }
    }
    public function logout()
    {
        unset($_SESSION['user']);

        redirect('/');
    }
}
