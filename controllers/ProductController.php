<?php
require_once __DIR__.'/../classes/BaseController.php';
require_once __DIR__.'/../models/Model.php';

class ProductController extends BaseController{

    public function __construct(){
        parent::__construct();
    }
    public function index(){
        //vérifier si l'utilisateur est connecté
        $this->checkLoggedIn();
        $message = '';
        $edit_mode = false; //variable pour vérifier si le mode édition est activé
        $edit_product = null; //variable pour stocker les données du produit à éditer
           $model = new Model();
        //enregistrer un produit
        if (isset($_POST['save_product'])) {
            $name = $_POST['name'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $stock_quantity = $_POST['stock_quantity'];
            //vérifier si le produit existe déjà
            if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
                
                $product_id = $_POST['product_id'];
                $model->updateProduct($name, $category, $price, $stock_quantity, $product_id);
                 $this->redirect("ProductController.php");
            } else {
    
              $model->createProduct($name, $category, $price, $stock_quantity);
                $message = "<p style='color:green;'>Product added successfully.</p>";
              
            }
    
        }
    
        //supprimer un produit
        if (isset($_GET['delete'])) {
            $product_id = $_GET['delete'];
           $model->deleteProduct($product_id);
           $this->redirect("ProductController.php");
        }
    
        //mode édition
        if (isset($_GET['edit'])) {
            $edit_mode = true;
            $product_id = $_GET['edit'];
           $edit_product = $model->getProductById($product_id);

        }
    
        // Fetch all products

        $products = $model->getProducts();
           $data = [
               'message' => $message,
                'edit_mode' => $edit_mode,
                'edit_product' => $edit_product,
                'products' => $products
           ];
        
        $this->render('product_manage.html.php', $data);
    }
}

$productController = new ProductController();
$productController->index();
?>