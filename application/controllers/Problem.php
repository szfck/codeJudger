<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Problem extends CI_Controller {

	public function index()
	{
		$this->load->view('problem');
	}

	public function get_problem($problem){
		$this->load->helper('file');
		$problem_name = ucfirst($problem);
		$desc = read_file(FCPATH."/problems/".$problem."/desc.txt");
		$sample_input = read_file(FCPATH."/problems/".$problem."/sample-input.txt");
		$sample_output = read_file(FCPATH."/problems/".$problem."/sample-output.txt");

		$data = array('problem_name'=>$problem_name, 'desc'=>$desc, 'sample_input'=>$sample_input, 'sample_output'=>$sample_output);
		$this->load->view('/templates/problem_template',$data);
	}

}
