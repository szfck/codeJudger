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
    <textarea name="codetext" cols="100" rows="30"></textarea><br>
    <input type="submit" value="submit code">
    </form>
	</div>
    <?php 
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            echo 'submitted:<br>';
            $code = $_POST['codetext'];
            echo $code;
        }
    ?>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>