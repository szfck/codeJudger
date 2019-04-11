<?php

class Register_test extends TestCase
{
	public function setUp()
    {
		$this->resetInstance();
		$this->CI->load->model('User_model');
		$this->obj = $this->CI->User_model;
	}

	public function test_index()
	{
		$output = $this->request('GET', 'register/index');
		$this->assertContains('<title>CodeJudger</title>', $output);
	}

	public function test_method_404()
	{
		$this->request('GET', 'register/method_not_exist');
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

	public function test_register_user(){
		$output = $this->request('POST', 'register/register_user', array('user_email' => 'rj1234@nyu.edu', 'user_name' => 'rajeev', 'user_password' => '123456'));

		$user=array(
			'useremail'=>'rj1234@nyu.edu',
            'user_name'=>"rajeev",
            'user_password'=>md5(123456)
		);

		$email_check = $this->obj->email_check($user['useremail']);
		if($email_check){
			$this->assertRedirect('login');
		}
		else{
			$this->assertRedirect('register');
		}
	}

}