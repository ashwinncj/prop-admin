<?php

class Auth extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function is_sudo() {
        return $_SESSION['sudo'] ? TRUE : FALSE;
    }

    public function authenticate($user, $pwd) {
        $this->load->database();
        $this->db->from('user_meta');
        $this->db->where('user_email', $user);
        $this->db->where('user_password', $this->password($pwd));
        $records = $this->db->count_all_results();
        return $records == 1 ? TRUE : FALSE;
    }

    public function password($pwd) {
        return md5('alp' . md5($pwd) . 'tmr');
    }

    public function is_user_logged_in() {
        if (isset($_SESSION['user_logged'])) {
            if ($_SESSION['user_logged'] == TRUE && isset($_SESSION['user_email'])) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function user_exists($user) {
        $this->load->database();
        $this->db->from('user_meta');
        $this->db->where('user_email', $user);
        $records = $this->db->count_all_results();
        return $records >= 1 ?
                $_SESSION['error_msg'] = 'Email provided is already registered. Please check the details provided.' AND TRUE : FALSE;
    }

    public function add_user($params) {
        $this->load->database();
        //Check if user exists before proceeding
        if ($this->user_exists($params['user_email'])) {
            $_SESSION['error_msg'] = 'Email provided is already registered. Please check the details provided.';
            return FALSE;
        }
        $hash = md5(uniqid());
        $data = array(
            'user_email' => $params['user_email'],
            'user_password' => $this->password($params['user_password']),
            'user_full_name' => $params['user_full_name'],
            'user_organization' => $params['user_organization'],
            'hash' => $hash
        );
        $status = $this->db->insert('user_meta', $data) ? TRUE : FALSE;
        return $status;
    }

}
