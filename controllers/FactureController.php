<?php
require_once __DIR__.'/../classes/BaseController.php';
require_once __DIR__.'/../models/Model.php';
class FactureController extends BaseController{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        //vérifier si l'utilisateur est connecté
        $this->checkLoggedIn();
        $model = new Model();
        //supprimer une facture
        if (isset($_GET['delete'])) {
            $invoice_id = $_GET['delete'];
             $model->deleteInvoice($invoice_id);
           echo "<p style='color:red;'>Invoice deleted successfully!</p>";
        }
    
        // Fetch all invoices et afficher la liste des factures
        $invoices = $model->getInvoices();
         $data = [
             'invoices' => $invoices
           ];
        $this->render('facture_manage.html.php', $data);
    }
}
$factureController = new FactureController();
$factureController->index();

?>