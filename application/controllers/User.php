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
        $this->load->model('submission_model');
        $this->load->view('/templates/default_layout', $content);
    }

    public function user_logout(){
        $this->session->sess_destroy();
        redirect('home', 'refresh');
    }

    public function get_user_details(){
		$user = $_POST['user'];
        $data = $this->user_model->get_user_details($user);

        $username = $data['username'];
        $useremail = $data['useremail'];
        $role = $data['role'];
        $response = array("username"=>$username, "useremail"=>$useremail, "role"=>$role);
		echo json_encode($response);
        if($data){
			$this->session->set_flashdata('Success', 'Successfully retieved the '.$user.' data :)');	
		}else{
			$this->session->set_flashdata('Failed', "Failed to retieved the ".$user." data");	
		}
    }
}
?>