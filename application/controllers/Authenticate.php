<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth');
    }

    public function index() {
        
    }

    public function login() {
        if (isset($_POST['user_email']) && $_POST['user_password']) {
            $auth = $this->auth->login($_POST['user_email'], $_POST['user_password']);
            if ($auth) {
                $_SESSION['user_logged'] = TRUE;
                $_SESSION['user_email'] = $_POST['user_email'];
            }
        }
    }

}
