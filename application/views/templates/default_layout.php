<!DOCTYPE html>
<html>
	<head>
		<title> CodeJudger </title>
	</head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	</head>
	<body>
		<div class="topnav">
			<a href="<?php echo base_url('home') ?>">CodeJudger</a>
			<a href="#">Problems</a>
			<a href="#">Articles</a>
            <a href="#">Discuss</a>

			<div class="topnav-right" style="float: right;">
                <?php if (isset($_SESSION['user_name'])) { ?>
                    <a href="<?=base_url('user')?>"><?=$_SESSION['user_name']?></a>
                <?php } else { ?>
                    <a href="<?=base_url('register')?>">Register here</a>
                    <a href="<?=base_url('login')?>">Login here</a>
                <?php } ?>
			</div>
		</div>
		<br>

		<div id="main-content" class="container">
            <?php if (isset($content['data'])) { ?>
                <?php $this->load->view($content['view'], $content['data']); ?>
            <?php } else { ?>
                <?php $this->load->view($content['view']); ?>
            <?php } ?>
        </div>

        <footer class="footer">
            <small>&copy; Copyright 2019 Code Judger</small>
        </footer>

	</body>
</html>