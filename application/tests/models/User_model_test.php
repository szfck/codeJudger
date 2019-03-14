<?php

class User_model_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('User_model');
        $this->obj = $this->CI->User_model;
    }

    public function test_login_user()
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

}
