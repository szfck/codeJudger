<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Problemdata extends CI_Controller {

    public function __construct(){    
        parent::__construct();
        $this->load->helper('file');
	}

    public function get_problem_desc($problem){
        $desc = read_file(FCPATH."/problems/".$problem."/desc.txt");
        echo json_encode($desc);
    }

    public function get_problem_sample_input($problem){
		$sample_input = read_file(FCPATH."/problems/".$problem."/sample-input.txt");
        echo json_encode($sample_input);
    }

    public function get_problem_sample_output($problem){
		$sample_output = read_file(FCPATH."/problems/".$problem."/sample-output.txt");
        echo json_encode($sample_output);
    }

    public function get_problem_config($problem){
        $config_yml_path = FCPATH.'/problems/'.$problem."/config.yml";
        $config_yml = file_get_contents($config_yml_path);
        echo json_encode($config_yml);
    }

    public function remove_problem($problem){
        $problem_dir = FCPATH.'/problems/'.$problem."/";
        $deleted = delete_files($problem_dir, TRUE);
        rmdir($problem_dir);
        echo json_encode($deleted);
    }

    public function get_problem_details(){
        $problem = $_POST['problem'];
        $value = $_POST['value'];

        if ($value == "description") {
            redirect('problemdata/get_problem_desc/'.$problem);
        }elseif ($value == "input") {
            redirect('problemdata/get_problem_sample_input/'.$problem);            
        }elseif ($value == "output") {
            redirect('problemdata/get_problem_sample_output/'.$problem);            
        }elseif ($value == "config") {
            redirect('problemdata/get_problem_config/'.$problem);            
        }elseif ($value == "remove") {
            redirect('problemdata/remove_problem/'.$problem);
        }

        echo json_encode("hello");
    }

}