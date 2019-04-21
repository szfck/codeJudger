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
            'view' => 'addProblem',
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

	public function add_skeleton_code_view(){
		$data = array('content'=> array(
			'view' => 'addSkeletonCode',
        ));
		$this->load->view('/templates/default_layout',$data);
	}
	
	public function modify_problem_config_view(){
		$data = array('content'=> array(
			'view' => 'modifyProblemConfig',
        ));
		$this->load->view('/templates/default_layout',$data);
	}

	public function add_problem(){
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
			$this->session->set_flashdata('Success', $problem["problemName"].' added successfullt :) Please also add the test cases for this Problem.');
		}else{
			$this->session->set_flashdata('Failed', "Failed to add the ".$problem["problemName"]);	
		}
		redirect('contribute/add_testcase_view');
	}

	public function add_testcase(){
		$problemName = $_POST['problem'];
		$testInput = $_POST['input'];
		$testOutput = $_POST['output'];

		$data = $this->contribute_model->add_testcase($problemName, $testInput, $testOutput);
		
		echo json_encode($data);

		if($data){
			$this->session->set_flashdata('Success', 'Testcase for '.$problemName.' added successfully :)');
		}else{
			$this->session->set_flashdata('Failed', "Failed to add the testcase for ".$problemName);	
		}
		redirect('contribute/add_testcase_view');
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

	public function get_skeleton_code(){
		$problemName = $_POST['problem'];
		$language = $_POST['language'];
		
		$code = $this->contribute_model->get_skeleton_code($problemName, $language);
		echo json_encode($code);
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

	public function get_problem_config(){
		$problemName = $_POST['problem'];
		$config = $this->contribute_model->get_problem_config($problemName);
		echo json_encode($config);
	}

	public function update_config_file(){
		$problemName = $_POST['problem'];
		$timelimit = $_POST['timelimit'];
		$testcase = $_POST['testcase'];
		$config = array('timelimit'=>$timelimit , 'testcase'=>$testcase);
		$data = $this->contribute_model->update_config_file($problemName, $config);
		echo json_encode($data);
		if($data){
			$this->session->set_flashdata('Success', 'Configuration file for '.$problemName.' updated successfully :)');	
		}else{
			$this->session->set_flashdata('Failed', "Failed to update the configuration for ".$problemName);	
		}
	}
}