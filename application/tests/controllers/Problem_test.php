<?php

class Problem_test extends TestCase
{
	public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->helper('problem_helper');
        $this->CI->load->library('session');

    }

	public function test_index()
	{
		$output = $this->request('GET', 'home/index');
		$this->assertContains('<title> CodeJudger </title>', $output);
	}

	public function test_get_problem()
	{
        $problem_array = array();
        foreach (get_problem_list() as $problem ) {
            array_push($problem_array, $problem);
        }
        $c = count($problem_array);
        for ($i=0; $i < $c; $i++) { 
	        $output = $this->request('GET', 'problem/get_problem/'.$problem_array[$i]);
			$this->assertContains('<title>CodeJudger</title>', $output);
			$this->assertContains("<tr><td> <php $problem_number; ?>. <a><php ucfirst($problem) ?></a> </td></tr>", $output);
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