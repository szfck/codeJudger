<?php

class Problem_test extends TestCase
{
	public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->helper('problem_helper');
        $this->CI->load->library('session');
        $this->CI->load->helper('file');
    }

	public function test_index()
	{
		$output = $this->request('GET', 'home/index');
		$this->assertContains('<title> CodeJudger </title>', $output);
	}

	public function test_get_problem(){	
		
		$this->request->setCallable(
			function ($CI) {
				$CI->session->user_id = NULL;
			}
		);
		
        $output = $this->request('GET', 'login/index');
		$this->assertContains('<title> CodeJudger </title>', $output);
		
		$this->request->setCallable(
			function ($CI) {
				$CI->session->user_id = 1;
			}
		);
		
        foreach (get_problem_list() as $problem ) {
        	$problem_name = $problem;
			$desc = read_file(FCPATH."/problems/".$problem."/desc.txt");
			$sample_input = read_file(FCPATH."/problems/".$problem."/sample-input.txt");
			$sample_output = read_file(FCPATH."/problems/".$problem."/sample-output.txt");       
	        $output = $this->request('GET', 'problem/'.$problem_name);
			$this->assertContains('<title> CodeJudger </title>', $output);
			$this->assertContains('<p>'.$desc.'</p>', $output);
		}
	}

	public function test_method_404()
	{
		$this->request('GET', 'welcome/method_not_exist');
		$this->assertResponseCode(404);
	}

	public function test_APPPATH()
	{
		$actual = realpath(APPPATH);
		$expected = realpath(__DIR__ . '/../..');
		$this->assertEquals(
			$expected,
			$actual,
			'Your APPPATH seems to be wrong. Check your $application_folder in tests/Bootstrap.php'
		);
	}
}
