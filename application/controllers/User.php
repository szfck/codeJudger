<?php
 
class User extends CI_Controller {
    
    public function __construct(){
    
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->library('session');
    
    }

    public function index(){
        $this->load->view("register.php");
    }

    public function register_user(){
        $user=array(
        'username'=>$this->input->post('user_name'),
        'password'=>md5($this->input->post('user_password')),
        );
        print_r($user);
   
        $name_check=$this->user_model->name_check($user['user_name']);
   
        if($name_check){
        $this->user_model->register_user($user);
        $this->session->set_flashdata('success_msg', 'Registered successfully.Now login to your account.');

        redirect('user/login_view');

        }
        else{

        $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
        redirect('user');


        }

    }

    public function login_view(){
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
        
                $this->load->view('user_profile.php');
        
            }
            else{
                $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
                $this->load->view("login.php");
        
            }
            
            
    }

    function user_profile(){
        $this->load->view('user_profile.php');
        }

    public function user_logout(){
        $this->session->sess_destroy();
        redirect('user/login_view', 'refresh');
    }

}
?>