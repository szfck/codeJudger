<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contribute extends CI_Controller {

	public function __construct(){
    
        parent::__construct();
        $this->load->helper('url', 'file');
        $this->load->model('contribute_model');
        $this->load->library('session');
    
	}
	
	public function index()
	{
		$data = array('content'=> array(
            'view' => 'contribute',
        ));
		$this->load->view('/templates/default_layout',$data);
	}

	public function add_problem_view(){
		$data = array('content'=> array(
            'view' => 'addProblem',
        ));
		$this->load->view('/templates/default_layout',$data);
	}

	public function add_testcase_view(){
		$data = array('content'=> array(
            'view' => 'addTestcase',
        ));
		$this->load->view('/templates/default_layout',$data);
	}

	public function add_problem(){
		$language = $this->input->post('language');

		if ($language == 'py2' || 'py3'){
			$language = 'py';
		}
		$problem = array("problemName"=>$this->input->post('problemName'),
		"problemDesc"=>$this->input->post('problemDesc'),
		"sampleInput"=>$this->input->post('sampleInput'),
		"sampleOutput"=>$this->input->post('sampleOutput'));
		// Set flash data 
		$data=$this->contribute_model->add_problem($problem["problemName"],
												$problem["problemDesc"],
												$problem["sampleInput"],
												$problem["sampleOutput"]);
		if($data){
			$this->session->set_flashdata('Success', $problem["problemName"].' added successfullt :)\n Please also add the Skeleton code for this Problem.');
			$this->session->set_flashdata('message',  'Please also add the Skeleton code for this Problem.');
		}else{
			$this->session->set_flashdata('Failed', "Failed to add the ".$problem["problemName"]);	
		}
		redirect('contribute/add_skeleton_code_view');
	}

	public function add_skeleton_code_view(){
		$data = array('content'=> array(
			'view' => 'addSkeletonCode',
        ));
		$this->load->view('/templates/default_layout',$data);
	}

	function get_problem_details() {
		$problem_name = $_POST['problem'];

		$problem_dir = FCPATH.'/problems/'.$problem_name."/";
		$problem_desc = read_file($problem_dir."desc.txt");
		$problem_sample_input = read_file($problem_dir."sample-input.txt");
		$problem_sample_output = read_file($problem_dir."sample-output.txt");
		$data = array("problem_desc" => $problem_desc,
						"problem_input" => $problem_sample_input,
						"problem_output" => $problem_sample_output);
		echo json_encode($data);
	}

	public function add_skeleton_code(){
		$problemName = $_POST['problem'];
		$skeletonCode = $_POST['code'];
		$language = $_POST['language'];
		
		$data = $this->contribute_model->add_skeleton_code($problemName, $skeletonCode, $language);
		echo json_encode($data);
		if($data){
			$this->session->set_flashdata('Success', 'Skeleton code for '.$problemName.' added successfully :)');	
		}else{
			$this->session->set_flashdata('Failed', "Failed to add the skeleton code for ".$problemName);	
		}
	}
}