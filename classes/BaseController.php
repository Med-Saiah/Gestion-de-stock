<?php
require_once 'Database.php';
require_once 'Session.php';

class BaseController {
    protected $db;
    protected $session;
    //instancier la classe Database et la classe Session    
    public function __construct() {
        $this->db = new Database();
        $this->session = new Session();
    }
    //rediriger vers une autre page
    protected function redirect($url) {
        header("Location: " . $url);
        exit();
    }
    //vérifier si l'utilisateur est connecté
    protected function isLoggedIn() {
       return $this->session->exists('username');
    }
    //vérifier si l'utilisateur est connecté
    protected function checkLoggedIn() {
        if(!$this->isLoggedIn()){
            echo "<p>Please log in to access this page.</p>";
            exit();
        }
    }
    //afficher une vue
     protected function render($view, $data = []) {
        extract($data);
        include __DIR__.'/../views/' . $view;
    }
}