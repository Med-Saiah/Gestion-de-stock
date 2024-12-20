<?php
require_once __DIR__.'/../classes/BaseController.php';
require_once __DIR__.'/../models/Model.php';

class MainController extends BaseController {
    public function __construct() {
        parent::__construct();
    }

    public function index() {

        //vérifier si l'utilisateur est connecté
        $this->checkLoggedIn();
         $role =  $this->session->get('role');
           $model = new Model();
          $products = $model->getProducts();
        if (!$this->session->exists('cart')) {
            $this->session->set('cart', []);
        }
    
        $message = '';
    
        //logout
        if (isset($_POST['logout'])) {
            $this->session->destroy();
            $this->redirect("LoginController.php");
        }
    
    
        //eviter sélectionner un client inexistant
        if (isset($_POST['client_id']) && $_POST['client_id'] != '0') {
            $this->session->set('client_id', $_POST['client_id']);
        } elseif (isset($_POST['client_id']) && $_POST['client_id'] == '0') {
            $message = "<p style='color:red;'>Please select a valid client.</p>";
        }
    
        //ajouter un produit au panier
   if (isset($_POST['add_to_cart']) && $this->session->exists('client_id')) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    //eviter sélectionner un produit inexistant
    if (!is_numeric($product_id)) {
        $message = "<p style='color:red;'>Invalid product selected. Please choose a valid product.</p>";
    } else {
        //variable pour vérifier si le produit existe déjà dans le panier
        $product_exists = false;

         $product = $model->getProductById($product_id);
        if ($product && $product->stock_quantity >= $quantity) {
            //enregistrer le produit dans le panier et calculer le sous-total
             $cart = $this->session->get('cart');
             foreach ($cart as &$cart_item) {
                 if ($cart_item['id'] == $product_id) {
                      $cart_item['quantity'] += $quantity;
                      $cart_item['subtotal'] = $cart_item['price'] * $cart_item['quantity'];
                      $product_exists = true;
                      break;
                }
            }

            //si le produit n'existe pas dans le panier, l'ajouter
            if (!$product_exists) {
                 $cart[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'subtotal' => $product->price * $quantity,
                 ];

             }
               $this->session->set('cart', $cart);
        } else {
            $message = "<p style='color:red;'>Insufficient stock for this product. Available quantity: " . $product->stock_quantity . "</p>";
        }
    }
}
        //supprimer un produit du panier
        if (isset($_GET['delete_from_cart'])) {
            $index = $_GET['delete_from_cart'];
             $cart = $this->session->get('cart');
            unset($cart[$index]);
            $cart = array_values($cart);
            $this->session->set('cart', $cart);
            $this->redirect("MainController.php");
        }
    
        //calculer le total du panier
        $cart = $this->session->get('cart');
        $total = array_sum(array_column($cart, 'subtotal'));
        
        //enregistrer la facture
        if (isset($_POST['save_facture']) && $this->session->exists('client_id')) {
            if (empty($cart)) {
                $message = "<p style='color:red;'>Cannot save an empty invoice. Add products to the cart first.</p>";
            } else {
                //obtenir l'identifiant de l'utilisateur connecté et de l'identifiant du client pour enregistrer les données de la facture
                $user_id = $this->session->get('user_id');
                $client_id = $this->session->get('client_id');
                 
                   $client = $model->getClientById($client_id);
                     if (!$client) {
                         $message = "<p style='color:red;'>Invalid client selected</p>";
                     }else{

                    
                         $invoice_id = $model->createInvoice($user_id, $client_id, $total);
                            // Insert the products into the invoice_products table
                            foreach ($cart as $item) {
                                 $model->createInvoiceProducts($invoice_id, $item);
                                 // Update the product stock
                                 $model->updateProductStock($item['id'], $item['quantity']);
                            }
        
                            // Clear the cart after saving the invoice
                           $this->session->set('cart', []);
                            $model->updateClientPurchase($total, $client_id);
                            $this->session->unset('cart');
                            $this->session->unset('client_id');
                            $message = "<p style='color:green;'>Facture saved successfully!</p>";
                     }
                }
         }
    
    
        //annuler la facture
        if (isset($_POST['cancel_facture'])) {
            $this->session->set('cart', []);
            $this->session->unset('client_id');
            //redirect est une fonction de la classe parente prédéfinie dans BaseController.php
            $this->redirect("MainController.php");
    
        }
        //obtenir la liste des clients
        $clients = $model->getClients("with phone");
        //afficher la vue
        $data = [
            'role' => $role,
            'message' => $message,
            'products' => $products,
            'clients' => $clients,
            'total' => $total,
           'cart' =>  $this->session->get('cart')
        ];

        //render est use fonction de la classe parente prédéfinie dans BaseController.php
        $this->render('main.html.php', $data);
    }

}
$mainController = new MainController();
$mainController->index();
?>