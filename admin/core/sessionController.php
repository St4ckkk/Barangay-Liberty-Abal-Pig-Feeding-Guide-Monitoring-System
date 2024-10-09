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



    public function login()
    {
        $query = "SELECT * FROM sk_members WHERE username = :username";
        $params = [':username' => $_POST['username']];
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $user = $stmt->fetch();

        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['u'] = $user['name'];
            $_SESSION['user'] = $user;
            $_SESSION['logged_in'] = true;
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Invalid username or password";
        }
    }
}
