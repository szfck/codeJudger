<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submission extends CI_Controller {

    public function __construct(){
    
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('submission_model');
        $this->load->library('session');
    
    }

	public function index()
	{
		$content = array('content'=> array(
            'view' => 'submission',
        ));
        $this->load->view('/templates/default_layout', $content);
    }
    
    public function detail($sub) {
        $path = FCPATH.'/submissions/'.$sub;
        $code = htmlspecialchars(file_get_contents($path));

		$content = array('content'=> array(
            'view' => 'code',
            'data' => array(
                'code' => $code
            )
        ));
        $this->load->view('/templates/default_layout', $content);
    }
    
    public function submit() {
        $problem = $_POST['problem'];
        $code = $this->input->post('code');
        $type = $this->input->post('type');
        $user_id = $_SESSION['user_id'];
        $this->submission_model->create_submission($problem, $user_id, $code, $type);
        
    }

}
