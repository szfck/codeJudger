<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to Code Judger</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" title="no title">
    <style>
        p.normal {font-weight:normal;}
        p.light {font-weight:lighter;}
        p.thick {font-weight:bold;}
        p.thicker {font-weight:900;}

        body {
            background-image:url(<?=base_url("/images/coding.jpeg"); ?>);
            background-repeat:no-repeat;
            background-size:100% 100%;
            background-attachment:fixed;
        }
    </style>
  </head>
  <body>
    <div class="container" style="background:url(application/views/images/coding.jpeg) no-repeat top right">
        <h1>Welcome to Code Judger</h1>
        <p class="thicker"> A New Way to Learn </p>
        <p class="thick"> Code Judger is a platform to help you enhance your skills, expand your knowledge and prepare for technical interviews.</p> 
        <center><b>Not registered ?</b> <br></b><a href="<?php echo base_url('register'); ?>">Register here</a></center><!--for centered text-->
        <center> <br></b><a href="<?php echo base_url('login'); ?>">Login here</a></center><!--for centered text-->
    </div>
  </body>
</html>
