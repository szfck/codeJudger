<?php

class User_model_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('User_model');
        $this->obj = $this->CI->User_model;
    }

    public function test_login_user_pass()
    {
        $expected = ['1', 'hello@codejudger.com', 'kai', '123456'];

        $name = 'kai';
        $pass = '123456';
        $list = $this->obj->login_user($name,$pass);
        $i = 0;
        foreach ($list as $value) {
            $this->assertEquals($expected[$i], $value);
            $i = $i + 1;
        }
    }

    public function test_login_user_fail()
    {
        $expected = false;

        $testcases = array(array('kai', '123'), 
                            array('kia', '123456'), 
                            array('kia', '23456'));

        for($x = 0; $x < count($testcases); $x++){
            print($x);
            $name = $testcases[$x][0];
            $pass = $testcases[$x][1];

            $actual = $this->obj->login_user($name,$pass);            
            $this->assertEquals($expected, $actual);

        }
        
    }

    public function test_email_check_pass(){
        $email = 'hello@codejudger.com';

        $expected = false;
        $actual = $this->obj->email_check($email);
        $this->assertEquals($expected, $actual);

    }

    public function test_email_check_fail(){
        $email = 'invalid_email';
        
        $expected = true;
        $actual = $this->obj->email_check($email);
        $this->assertEquals($expected, $actual);

    }

}
