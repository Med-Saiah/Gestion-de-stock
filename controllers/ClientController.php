<?php
require_once __DIR__.'/../classes/BaseController.php';
require_once __DIR__.'/../models/Model.php';
class ClientController extends BaseController{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        //vérifier si l'utilisateur est connecté
        $this->checkLoggedIn();
    
        $message = '';
        $edit_mode = false;
        $edit_client = null;
        $model = new Model();
        //enregistrer un client
        if (isset($_POST['save_client'])) {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
        //vérifier si le client existe déjà
            if (isset($_POST['client_id']) && !empty($_POST['client_id'])) {
                $client_id = $_POST['client_id'];
               $model->updateClient($name, $phone, $client_id);
                 $this->redirect("ClientController.php");
            } else {
                 $model->createClient($name, $phone);
                $message = "<p style='color:green;'>Client added successfully.</p>";
            }
    
        }
    
        //supprimer un client
        if (isset($_GET['delete'])) {
            $client_id = $_GET['delete'];
           $model->deleteClient($client_id);
           $this->redirect("ProductController.php");
            $message = "<p style='color:red;'>Client deleted successfully.</p>";
        }
    
        //mode édition
        if (isset($_GET['edit'])) {
            $edit_mode = true;
            $client_id = $_GET['edit'];
           $edit_client = $model->getClientById($client_id);
        }
    
        // Fetch all clients et afficher la liste des clients
        $clients = $model->getClients();
          $data = [
            'message' => $message,
            'edit_mode' => $edit_mode,
             'edit_client' => $edit_client,
             'clients' => $clients
           ];

           $this->render('client_manage.html.php', $data);

    }
}

$clientController = new ClientController();
$clientController->index();
?>