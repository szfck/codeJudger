<?php
 
class User extends CI_Controller {
    
    public function __construct(){
    
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->library('session');
    
    }

    public function index(){
		$data = array('content'=>'user_profile');
		$this->load->view('/templates/default_layout',$data);
    }

    function user_profile(){
		$data = array('content'=>'user_profile');
		$this->load->view('/templates/default_layout',$data);
    }

    public function user_logout(){
        $this->session->sess_destroy();
        redirect('home', 'refresh');
    }

}
?>