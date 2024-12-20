<?php
require_once __DIR__.'/../classes/Database.php';

class Model
{
    protected $db;

    public function __construct(){
        $this->db = new Database();
    }
    //functions pour récupérer les données de la base de données
    public function getUsers(){
        return $this->db->getConnection()->query("SELECT * FROM users")->fetchAll(PDO::FETCH_OBJ);
    }
        public function getProducts(){
        return $this->db->getConnection()->query("SELECT * FROM products")->fetchAll(PDO::FETCH_OBJ);
    }
    public function getClients($phone=""){
           $sql = "SELECT * FROM clients";
        if($phone!=""){
             $sql .=  " WHERE phone != 'N/A'";
        }
        return $this->db->getConnection()->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }
       public function getInvoices(){
         return $this->db->getConnection()->query("SELECT i.id, i.total, i.created_at, u.username, c.name AS client_name 
                                 FROM invoices i 
                                 JOIN users u ON i.user_id = u.id 
                                 JOIN clients c ON i.client_id = c.id
                                 ORDER BY i.created_at DESC")->fetchAll(PDO::FETCH_OBJ);
       }
    public function getUserById($user_id){
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function getProductById($product_id){
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function getClientById($client_id){
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->execute([$client_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function getInvoiceById($invoice_id){
          $stmt = $this->db->getConnection()->prepare("SELECT i.id, i.total, i.created_at, u.username, c.name AS client_name 
                                  FROM invoices i 
                                  JOIN users u ON i.user_id = u.id 
                                  JOIN clients c ON i.client_id = c.id
                                  WHERE i.id = ?");
         $stmt->execute([$invoice_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

      public function getInvoiceProductsByInvoiceId($invoice_id){
           $stmt = $this->db->getConnection()->prepare("SELECT p.name, ip.quantity, ip.price, ip.subtotal 
                                   FROM invoice_products ip 
                                   JOIN products p ON ip.product_id = p.id 
                                   WHERE ip.invoice_id = ?");
         $stmt->execute([$invoice_id]);
         return  $stmt->fetchAll(PDO::FETCH_OBJ);
      }

      //functions pour mettre à jour les données dans la base de données
     public function updateUser($name, $phone, $username, $password, $role, $user_id){
         if ($password) {
             $stmt =  $this->db->getConnection()->prepare("UPDATE users SET name = ?, phone = ?, username = ?, password = ?, role = ? WHERE id = ?");
               $stmt->execute([$name, $phone, $username, $password, $role, $user_id]);
                } else {
                   $stmt =  $this->db->getConnection()->prepare("UPDATE users SET name = ?, phone = ?, username = ?, role = ? WHERE id = ?");
                   $stmt->execute([$name, $phone, $username, $role, $user_id]);
                }

    }
     public function updateProduct($name, $category, $price, $stock_quantity, $product_id){
          $stmt = $this->db->getConnection()->prepare("UPDATE products SET name = ?, category = ?, price = ?, stock_quantity = ? WHERE id = ?");
          $stmt->execute([$name, $category, $price, $stock_quantity, $product_id]);

    }
        public function updateClient($name, $phone, $client_id){
          $stmt = $this->db->getConnection()->prepare("UPDATE clients SET name = ?, phone = ? WHERE id = ?");
            $stmt->execute([$name, $phone, $client_id]);
    }
    //functions pour supprimer les données de la base de données
         public function deleteUser($user_id){
              $stmt =  $this->db->getConnection()->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
         }
            public function deleteProduct($product_id){
            $stmt = $this->db->getConnection()->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
         }
           public function deleteClient($client_id){
           $stmt = $this->db->getConnection()->prepare("DELETE FROM clients WHERE id = ?");
            $stmt->execute([$client_id]);
          }
            public function deleteInvoice($invoice_id){
                 $stmt = $this->db->getConnection()->prepare("DELETE FROM invoice_products WHERE invoice_id = ?");
            $stmt->execute([$invoice_id]);
             $stmt = $this->db->getConnection()->prepare("DELETE FROM invoices WHERE id = ?");
            $stmt->execute([$invoice_id]);

          }
    //functions pour créer les données dans la base de données
    public function createUser($name, $phone, $username, $password, $role){
          $stmt = $this->db->getConnection()->prepare("INSERT INTO users (name, phone, username, password, role) VALUES (?, ?, ?, ?, ?)");
               $stmt->execute([$name, $phone, $username, $password, $role]);

    }
      public function createProduct($name, $category, $price, $stock_quantity){
              $stmt = $this->db->getConnection()->prepare("INSERT INTO products (name, category, price, stock_quantity) VALUES (?, ?, ?, ?)");
              $stmt->execute([$name, $category, $price, $stock_quantity]);

      }
      public function createClient($name, $phone){
             $stmt = $this->db->getConnection()->prepare("INSERT INTO clients (name, phone, number_of_purchases, total_spent) VALUES (?, ?, 0, 0)");
                $stmt->execute([$name, $phone]);
      }
      public function createInvoice($user_id, $client_id, $total){
              $stmt = $this->db->getConnection()->prepare("INSERT INTO invoices (user_id, client_id, total) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $client_id, $total]);
             return  $this->db->getConnection()->lastInsertId();
      }
      public function createInvoiceProducts($invoice_id, $item){
           $stmt = $this->db->getConnection()->prepare("INSERT INTO invoice_products (invoice_id, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$invoice_id, $item['id'], $item['quantity'], $item['price'], $item['subtotal']]);
      }
      //function pour mettre à jour le nombre d'achats et le total dépensé par le client
      public function updateClientPurchase($total, $client_id){
           $stmt = $this->db->getConnection()->prepare("UPDATE clients SET number_of_purchases = number_of_purchases + 1, 
                                total_spent = total_spent + ? WHERE id = ?");
                    $stmt->execute([$total, $client_id]);
      }
       public function getUserByUsername($username){
         $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE username = ?");
          $stmt->execute([$username]);
          return $stmt->fetch(PDO::FETCH_OBJ);
      }
      //function pour mettre à jour la quantité de stock du produit
       public function updateProductStock($product_id, $quantity){
          $stmt = $this->db->getConnection()->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
          $stmt->execute([$quantity, $product_id]);
      }

}