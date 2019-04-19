<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submission extends CI_Controller {

    public function __construct(){
    
        parent::__construct();
        $this->load->helper('url', 'file');
        $this->load->model('submission_model');
        $this->load->library('session');
    
    }

	public function index()
	{
		// $content = array('content'=> array(
        //     'view' => 'submission',
        // ));
        // $this->load->model('submission_model');
        // $this->load->view('/templates/default_layout', $content);
    }

    public function user_submission_list() {
		if (!$_SESSION['user_id']){
			redirect('login');
		}
        $user_id = $_SESSION['user_id'];
        $content = array('content'=> array(
            'view' => 'submission',
            'data' => array(
                'submissions' => $this->submission_model->get_user_submission_list($user_id)
            )
        ));

        $this->load->view('/templates/default_layout', $content);

    }

    public function all_submission_list() {
        $content = array('content'=> array(
            'view' => 'submission',
            'data' => array(
                'submissions' => $this->submission_model->get_user_submission_list(-1)
            )
        ));

        $this->load->view('/templates/default_layout', $content);
    }
    
    public function detail($sub_id) {
		if (!$_SESSION['user_id'] || !$_SESSION['role']){
			redirect('login');
        }
        
        $session_user_id = $_SESSION['user_id'];

        $sub = $this->submission_model->get_submission($sub_id);
        $user_id = $sub->userid;
        $file_name = $sub->filename;
        $problem = $sub->problem;

		if ($_SESSION['role'] != 'admin' && $user_id != $session_user_id){
            echo "You have no access to this submission!";
            return;
		}

        $user_path = FCPATH.'/submissions/'.$user_id."/";
        $code_path = $user_path.$file_name;

        // parse problem config.yml file
        $config_yml_path = FCPATH.'/problems/'.$problem."/config.yml";
        $config_yml = file_get_contents($config_yml_path);
        $array = explode("\n", $config_yml);
        foreach ($array as $item) {
            $string = str_replace(' ', '', $item);
            if (strcmp($string, '') == 0) continue;
            $key_value = explode(":", $string);
            if ($key_value[0] == 'timelimit') $timelimit = $key_value[1];
            if ($key_value[0] == 'testcase') $testcase = $key_value[1];
        }

        // fetch code
        $code = htmlspecialchars(file_get_contents($code_path));

        $content = array('content'=> array(
            'view' => 'detail',
            'data' => array(
                'code' => $code,
                'sub' => $sub,
                'timelimit' => $timelimit,
                'testcase' => $testcase
            )
        ));

        $this->load->view('/templates/default_layout', $content);
    }

    public function submit() {
        $problem = $_POST['problem'];
        $code = $this->input->post('code');
        $type = $this->input->post('type');

        $user_id = $_SESSION['user_id'];

        $sub_id = $this->submission_model->create_submission($problem, $user_id, $code, $type);

        echo $sub_id;
    }

}
