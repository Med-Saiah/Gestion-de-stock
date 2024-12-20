<?php
require_once __DIR__.'/../classes/BaseController.php';
require_once __DIR__.'/../models/Model.php';

class InvoiceViewController extends BaseController{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
      //vérifer si l'utilisateur est connecté
      $this->checkLoggedIn();
    
        $invoice_id = $_GET['id'];
    
          $model = new Model();
         $invoice = $model->getInvoiceById($invoice_id);
    
        // Fetch all products
        $products = $model->getInvoiceProductsByInvoiceId($invoice_id);
         $data = [
             'invoice' => $invoice,
              'products' => $products,
            ];
           $this->render('invoice_view.html.php', $data);
    }
}

$invoiceViewController = new InvoiceViewController();
$invoiceViewController->index();
?>