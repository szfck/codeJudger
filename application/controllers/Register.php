<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct(){
    
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->library('session');
    
	}

	public function index(){
        $data = array('content'=>'register');
        $this->load->view('/templates/default_layout',$data);
    }

    public function register_user(){
        $user=array(
        'useremail'=>$this->input->post('user_email'),
        'username'=>$this->input->post('user_name'),
        'password'=>md5($this->input->post('user_password')),
        );
        print_r($user);
   
        $email_check=$this->user_model->email_check($user['useremail']);
   
        if($email_check){
        $this->user_model->register_user($user);
        $this->session->set_flashdata('success_msg', 'Registered successfully.Now login to your account.');

        redirect('login');

        }
        else{

        $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
        redirect('register');


        }

    }




}
