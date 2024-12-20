<?php
require_once __DIR__.'/../classes/BaseController.php';
require_once __DIR__.'/../models/Model.php'; 

class LoginController extends BaseController{
 public function __construct() {
        parent::__construct();
    }

    public function index(){
        $message = '';
        if (isset($_POST['username'], $_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $model = new Model();
            $user = $model->getUserByUsername($username);

            if ($user && password_verify($password, $user->password)) {
                $this->session->set('username', $user->username);
                $this->session->set('role', $user->role);
                $this->session->set('user_id', $user->id);
                $this->redirect("MainController.php");
    
            } else {
                $message = "Invalid username or password.";
            }
    
        }
    $this->render('login.html.php', ['message' => $message]);
    }
}
$loginController = new LoginController();
$loginController->index();
?>