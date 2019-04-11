<?php

class Login_test extends TestCase
{
	public function setUp()
    {
		$this->resetInstance();
		$this->CI->load->model('User_model');
        $this->CI->load->library('session');		
		$this->obj = $this->CI->User_model;
	}
	
	public function test_index()
	{
		$output = $this->request('GET', 'login/index');
		$this->assertContains('<title>CodeJudger</title>', $output);
	}

	public function test_method_404()
	{
		$this->request('GET', 'login/method_not_exist');
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

	public function test_login_user_success(){
		// testing for successfull Login
		$output = $this->request('POST', 'login/login_user', array('user_name' => 'rajeev', 'user_password' => '123456'));

		$user_login=array(
            'user_name'=>"rajeev",
            'user_password'=>md5(123456)
		);

		$data = $this->obj->login_user($user_login['user_name'],$user_login['user_password']);
		if($data){
			$this->assertRedirect('home');
		}
		
	}

	public function test_login_user_failure(){
		// Testing for Unsuccessful login
		$output = $this->ajaxRequest('POST', 'login/login_user', array('user_name' => 'rajeev_wrong', 'user_password' => '123456'));
		
		$user_login=array(
            'user_name'=>"rajeev_wrong",
            'user_password'=>md5(123456)
		);

		$data = $this->obj->login_user($user_login['user_name'],$user_login['user_password']);
		if(!$data){
			$this->assertContains('<b>Not registered ?</b> ', $output);
		}

	}
}