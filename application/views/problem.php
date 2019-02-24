<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Code Judger</title>
</head>
<body>

<div id="container">
	<h1>Welcome to Code Judger!</h1>

	<div id="body">
    <hr>
    <?php 
        $desc = file_get_contents(PROPATH.'sum/desc.txt');
        $input = file_get_contents(PROPATH.'sum/sample-input.txt');
        $output = file_get_contents(PROPATH.'sum/sample-output.txt');
        echo '<h2>Description</h2>'.$desc.'</br>';
        echo '<h3>Input Sample</h3>'.$input.'</br>';
        echo '<h3>Output Sample</h3>'.$output.'</br>';
    ?>
    <hr>
    <h3>Code:</h3>
    <form method="POST">
    <textarea name="codetext" cols="100" rows="30">
        #include<iostream>
            using namespace std;
            int main() {
            int a, b;
            cin >> a >> b;
            cout << a + b << endl;
            return 0;
        }
    </textarea><br>
    <input type="submit" value="submit code">
    </form>
    </div>
    <h2>Judging Result</h2>
    <?php 
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $code = $_POST['codetext'];
            $filename = 'usercode.cpp';
            $file = fopen($filename, 'w');
            fwrite($file, $code);
            fclose($file);
            $input_path = PROPATH.'sum/sample-input.txt';
            $output_path = PROPATH.'sum/sample-output.txt';

            # compile and redirect stderr to stdout
            $compile_cmd = 'g++ usercode.cpp -o usercode 2>&1';
            shell_exec($compile_cmd);
            $compile_result = shell_exec($compile_cmd);

            if ($compile_result != '') {
                echo 'compile failed:</br>';
                echo $compile_result;
            } else {
                # run code
                $cmd =  './usercode < '.$input_path.' > result.txt';
                shell_exec($cmd);

                # compare result
                $diff_result = shell_exec('diff result.txt '.$output_path);
                if ($diff_result == '') echo 'Accepted</br>';
                else echo 'Wrong Answer</br>';
            }
        }
    ?>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>