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
		$content = array('content'=> array(
            'view' => 'submission',
        ));
        $this->load->model('submission_model');
        $this->load->view('/templates/default_layout', $content);
    }
    
    public function detail($sub_id) {
        $sub = $this->submission_model->get_submission($sub_id);
        $user_id = $sub->userid;
        $file_name = $sub->filename;
        $status = $sub->result;

        $user_path = FCPATH.'/submissions/'.$user_id."/";
        $code_path = $user_path.$file_name;

        $code = htmlspecialchars(file_get_contents($code_path));

        $content = array('content'=> array(
            'view' => 'detail',
            'data' => array(
                'code' => $code,
                'subid' => $sub_id
            )
        ));


        // if ($status != 'pending') {

        // } else {
        //     $result_json_path = $user_path.$sub_id.'.json';
        //     $content = array('content'=> array(
        //         'view' => 'detail',
        //         'data' => array(
        //             'code' => $code,
        //             'status' => $status,
        //             'result' => file_get_contents($result_json_path)
        //         )
        //     ));

        // }
        $this->load->view('/templates/default_layout', $content);
    }

    public function submit() {
        $problem = $_POST['problem'];
        $code = $this->input->post('code');
        $type = $this->input->post('type');

        $user_id = $_SESSION['user_id'];
        // $error_file = FCPATH."submissions/".$user_id."/error";
        // $output_file = FCPATH."submissions/".$user_id."/output";
        // $expected_output_file = FCPATH."submissions/".$user_id."/expected_output";
        $sub_id = $this->submission_model->create_submission($problem, $user_id, $code, $type);

        // $res = file_get_contents("http://judger-judge:3000/judge?submission_id=".$sub_id);
        // $error = read_file($error_file);
        // $output = read_file($output_file);
        // $expected_output = read_file($expected_output_file);
        // $data = array("res"=>$res, "output"=>$output, "expected_output"=>$expected_output, "error"=>$error);
        // echo json_encode($data);
        // echo $res;
        echo $sub_id;
    }

}
