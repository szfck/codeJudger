<?php
 
class User extends CI_Controller {
    
    public function __construct(){
    
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->library('session');
    
    }

    public function index(){
        $this->user_profile();
    }

    function user_profile(){
		$content = array('content'=> array(
            'view' => 'user_profile',
        ));
		$this->load->view('/templates/default_layout', $content);
    }

    public function user_logout(){
        $this->session->sess_destroy();
        redirect('home', 'refresh');
    }

}
?>