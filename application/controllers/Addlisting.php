<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Addlisting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('listing');
    }

    public function index() {
        $success = $this->listing->addlisting($_POST);
    }

}
