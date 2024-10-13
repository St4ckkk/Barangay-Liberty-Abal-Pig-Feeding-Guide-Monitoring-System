<?php


require_once 'Database.php';

class SessionController
{


    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function userLogin()
    {
        $query = "SELECT * FROM useraccount WHERE username = :username";
        $params = [':username' => $_POST['username']];
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $user = $stmt->fetch();

        if ($user && password_verify($_POST['password'], $user['password'])) {
            if ($user['status'] === 'active') {
                $_SESSION['id'] = $user['id'];
                $_SESSION['u'] = $user['username'];
                $_SESSION['user'] = $user;
                $_SESSION['logged_in'] = true;


                $_SESSION['role'] = $user['role'];

                header("Location: dashboard.php");
                exit;
            } else {
                echo "Your account is inactive. Please contact support.";
            }
        } else {
            echo "Invalid username or password.";
        }
    }


    public function logout()
    {

        $_SESSION = array();


        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();


        header("Location: ./index.php");
        exit();
    }
}
