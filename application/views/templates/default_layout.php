<!DOCTYPE html>
<html>

<head>
    <title> CodeJudger </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<!-- ace editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
    <div id="myTopnav" >
        <div class="topnav" >
            <a href="<?php echo base_url('home') ?>">CodeJudger</a>
            <a href="<?=base_url('queue')?>">Judge Queue</a>
            <a href="<?=base_url('myqueue')?>">My Submission</a>
            <a href="<?=base_url('article')?>">Articles</a>

            <div class="topnav-right" style="float: right;">
                <?php if (isset($_SESSION['user_name'])) { ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>  
                        <a href="<?php echo base_url('contribute')?>">Contribute</a>
                    <?php } ?>
                    <a href="<?=base_url('user')?>"><?=$_SESSION['user_name']?></a>
                    <a href="<?php echo base_url('user/user_logout');?>">Log out</a>
                <?php } else { ?>
                <a href="<?=base_url('register')?>">Register here</a>
                <a href="<?=base_url('login')?>">Login here</a>
                <?php } ?>
            </div>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
                </div>
    <div id="main">
        <?php if (isset($content['data'])) { ?>
        <?php $this->load->view($content['view'], $content['data']); ?>
        <?php } else { ?>
        <?php $this->load->view($content['view']); ?>
        <?php } ?>
    </div>

    <!-- <footer class="footer">
        <small>&copy; Copyright 2019 Code Judger</small>
    </footer> -->
    <script>
        function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav" ) {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
        }
    </script>
</body>
</html>
