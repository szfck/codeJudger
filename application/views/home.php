<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to Code Judger</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" title="no title">
    <style>
        p.normal {font-weight:normal;}
        p.light {font-weight:lighter;}
        p.thick {font-weight:bold;}
        p.thicker {font-weight:900;}

        /* body {
            background-image:url(<?=base_url("/images/coding.jpeg"); ?>);
            background-repeat:no-repeat;
            background-size:100% 100%;
            background-attachment:fixed;
        } */
    </style>
  </head>
  <body>
    <div class="container" style="background:url(application/views/images/coding.jpeg) no-repeat top right">
        <div style="float: left; height: 80px; width: 70%;">
            <h1 style="width: 70%;">Welcome to Code Judger</h1>
        </div>
        <div style="float: right; height: 80px; width: 30%; margin: auto;">
            <center><b>Not registered ?</b> </b><a href="<?php echo base_url('register'); ?>">Register here</a></center><!--for centered text-->
            <center> </b><a href="<?php echo base_url('login'); ?>">Login here</a></center><!--for centered text-->
        </div>

        <div class="container" style="margin: auto;">
            <p class="thicker"> A New Way to Learn </p>
            <p class="thick"> Code Judger is a platform to help you enhance your skills, expand your knowledge and prepare for technical interviews </p> 
        </div>
    </div>

    <div class="container">
        <?php include 'problem_list.php'; ?>
    </div>

  </body>
</html>
