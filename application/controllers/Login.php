<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index(){
        $this->load->view("login.php");
    }

    function login_user(){
        $user_login=array(
        'user_name'=>$this->input->post('user_name'),
        'user_password'=>md5($this->input->post('user_password'))
        
            );
        
            $data=$this->user_model->login_user($user_login['user_name'],$user_login['user_password']);
            if($data)
            {
                $this->session->set_userdata('user_id',$data['id']);
                $this->session->set_userdata('user_name',$data['username']);
                redirect('user');
        
            }
            else{
                $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
                $this->load->view("login.php");
        
            }
            
            
    }

}
