<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skeleton extends CI_Controller {

    public function __construct(){
    
        parent::__construct();
        $this->load->helper('file');
        $this->load->library('session');
    
    }

	public function get_skeleton_code(){
        $problem = $_POST['problem'];
        $type = $this->input->post('type');
        $user_id = $_SESSION['user_id'];
        $type = ($type == 'python') ? 'py' : $type;
        $skeleton_code_file = FCPATH."problems/".$problem."/skeleton.".$type;

        $skeleton_code = read_file($skeleton_code_file);
        echo $skeleton_code;
    }

}
