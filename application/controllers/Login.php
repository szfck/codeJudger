<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
    
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->library('session');
    
    }
    
	public function index(){
		$content = array('content'=> array(
            'view' => 'login',
        ));
		$this->load->view('/templates/default_layout', $content);
    }

    function login_user(){
        $user_login=array(
            'user_name'=>$this->input->post('user_name'),
            'user_password'=>md5($this->input->post('user_password'))
        );
        
        $data=$this->user_model->login_user($user_login['user_name'],$user_login['user_password']);
        if($data) {
            $this->session->set_userdata('user_id',$data['id']);
            $this->session->set_userdata('user_name',$data['username']);
            $this->session->set_userdata('role',$data['role']);
            redirect('home');
        } else{
            $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
            $this->load->view("login.php");
        }
        
    }

}
