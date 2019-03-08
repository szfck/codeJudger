<?php
 
class User extends CI_Controller {
    
    public function __construct(){
    
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->library('session');
    
    }

    public function index(){
        $this->load->view("user_profile.php");
    }

    function user_profile(){
        $this->load->view('user_profile.php');
        }

    public function user_logout(){
        $this->session->sess_destroy();
        redirect('home', 'refresh');
    }

}
?>