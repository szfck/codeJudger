<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Problem extends CI_Controller {

	public function get_problem($problem){
		if (!$_SESSION['user_id']){
			redirect('login');
		}

		$this->load->helper('file');
		$problem_name = $problem;
		$desc = read_file(FCPATH."/problems/".$problem."/desc.txt");
		$sample_input = read_file(FCPATH."/problems/".$problem."/sample-input.txt");
		$sample_output = read_file(FCPATH."/problems/".$problem."/sample-output.txt");

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

		$content = array('content'=> array(
            'view' => 'templates/problem_template',
            'data' => array(
                'problem_name'=>$problem_name,
                'desc'=>$desc,
                'sample_input'=>$sample_input,
                'sample_output'=>$sample_output,
                'time_limit'=>$timelimit,
                'test_case'=>$testcase,
            )
        ));
        $this->load->view('/templates/default_layout', $content);
    }

    public function get_problem_detail(){
		if (!$_SESSION['user_id']){
			redirect('login');
        }
        
        $problem = $_POST['problem'];
        $value = $_POST['value'];

        if ($value == "desc.txt") {
            // # code...
        }elseif ($value == "sample-input.txt") {
            // # code...
        }elseif ($value == "sample-output.txt") {
            // # code...
        }elseif ($value == "config.yml") {
            // # code...
        }

        echo json_encode("hello");
    }

}
