<?php
// this code VERSION is only work with wamp server
class Database {
    private $pdo;
    private $dsn = 'mysql:host=localhost;';
    private $user = 'root';
    private $password = '';
    private $dbName = 'medsaiahstore';

    public function __construct() {
        try {
            
            $this->pdo = new PDO($this->dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("SET NAMES utf8mb4");//work only with wamp server

            $this->createDatabaseIfNotExists();

            $this->dsn .= "dbname=".$this->dbName.";";
            $this->pdo = new PDO($this->dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("SET NAMES utf8mb4");//work only with wamp server

            $this->createTablesIfNotExists();
            $this->seedTables();


        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    private function createDatabaseIfNotExists() {
         try {
              $this->pdo->query("CREATE DATABASE IF NOT EXISTS `$this->dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        } catch (PDOException $e) {
              die("Error creating database: " . $e->getMessage());
        }
    }

   private function createTablesIfNotExists() {
        $sql = "

            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                phone VARCHAR(15) UNIQUE NOT NULL,
                username VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin', 'user') DEFAULT 'user',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS clients (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                phone VARCHAR(15) UNIQUE NOT NULL,
                number_of_purchases INT DEFAULT 0,
                total_spent DECIMAL(10, 0) DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

            
            CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                category VARCHAR(255) NOT NULL,
                price DECIMAL(10, 0) NOT NULL,
                stock_quantity INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

            
            CREATE TABLE IF NOT EXISTS invoices (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                client_id INT NOT NULL,
                total DECIMAL(10, 0) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (client_id) REFERENCES clients(id)
            )ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

            
             CREATE TABLE IF NOT EXISTS invoice_products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                invoice_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                price DECIMAL(10, 0) NOT NULL,
                subtotal DECIMAL(10, 0) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (invoice_id) REFERENCES invoices(id),
                 FOREIGN KEY (product_id) REFERENCES products(id)
            )ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        ";
        try {
           $this->pdo->exec($sql);
        } catch (PDOException $e) {
            die("Error creating tables: " . $e->getMessage());
        }
    }
       private function seedTables() {
            try {
               
               $productCount = $this->pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
               if($productCount > 0){
                    return;
               }


                $users = [
                    ['name' => 'Admin User', 'phone' => '1234567890', 'username' => 'admin', 'password' => password_hash('admin', PASSWORD_BCRYPT), 'role' => 'admin'],
                    ['name' => 'User', 'phone' => '2345678901', 'username' => 'user', 'password' => password_hash('user', PASSWORD_BCRYPT), 'role' => 'user']
                ];

                  $stmt = $this->pdo->prepare("INSERT IGNORE INTO users (name, phone, username, password, role) VALUES (?, ?, ?, ?, ?)");
                foreach ($users as $user) {
                    $stmt->execute([$user['name'], $user['phone'], $user['username'], $user['password'], $user['role']]);
                }

                
                $clients = [
                   ['name' => 'Client 1', 'phone' => '6789012345'],
                   ['name' => 'Client 2', 'phone' => '7890123456'],
                ];
                $stmt = $this->pdo->prepare("INSERT IGNORE INTO clients (name, phone) VALUES (?, ?)");
                foreach ($clients as $client) {
                  $stmt->execute([$client['name'], $client['phone']]);
                }

                
                $products = [
                    ['name' => 'Fromage', 'category' => 'Produits laitiers', 'price' => 200, 'stock_quantity' => 50],
                    ['name' => 'Jus d\'orange', 'category' => 'Boissons', 'price' => 120, 'stock_quantity' => 100],
                    ['name' => 'Croissant', 'category' => 'Boulangerie', 'price' => 10, 'stock_quantity' => 300],
                    ['name' => 'Poulet', 'category' => 'Viandes', 'price' => 350, 'stock_quantity' => 60],
                    ['name' => 'Bananes', 'category' => 'Fruits', 'price' => 30, 'stock_quantity' => 150],
                ];
                $stmt = $this->pdo->prepare("INSERT IGNORE INTO products (name, category, price, stock_quantity) VALUES (?, ?, ?, ?)");
                 foreach ($products as $product) {
                    $stmt->execute([$product['name'], $product['category'], $product['price'], $product['stock_quantity']]);
                 }
            } catch (PDOException $e) {
                die("Error seeding tables: " . $e->getMessage());
            }
        }
    public function getConnection() {
        return $this->pdo;
    }
}