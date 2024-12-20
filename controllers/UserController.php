<?php
require_once __DIR__.'/../classes/BaseController.php';
require_once __DIR__.'/../models/Model.php';
class UserController extends BaseController{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        //vérifier si l'utilisateur est connecté
        $this->checkLoggedIn();

        $message = '';
        $edit_mode = false;//variable pour vérifier si le mode édition est activé
        $edit_user = null;//variable pour stocker les données de l'utilisateur à éditer
            $model = new Model();
        //enregistrer un utilisateur
        if (isset($_POST['save_user'])) {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $username = $_POST['username'];
            $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;
            $role = $_POST['role'];
            //vérifier si l'utilisateur existe déjà
            if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
                $user_id = $_POST['user_id'];
               $model->updateUser($name, $phone, $username, $password, $role, $user_id);
                 $this->redirect("UserController.php");
                 
    
            } else {
                 $model->createUser($name, $phone, $username, $password, $role);
                $message = "<p style='color:green;'>User added successfully.</p>";
            }
        
           $edit_mode = false;
           $edit_user = null;
        }
        //supprimer un utilisateur
        if (isset($_GET['delete'])) {
            $user_id = $_GET['delete'];
             $model->deleteUser($user_id);
            $this->redirect("UserController.php");
        }
    
        //mode édition
        if (isset($_GET['edit'])) {
            $edit_mode = true;
            $user_id = $_GET['edit'];
           $edit_user = $model->getUserById($user_id);
        }
    
        // Fetch all users
        $users = $model->getUsers();

        $data = [
            'message' => $message,
            'edit_mode' => $edit_mode,
             'edit_user' => $edit_user,
             'users' => $users
        ];
       $this->render('user_manage.html.php', $data);

    }
}

$userController = new UserController();
$userController->index();

?>