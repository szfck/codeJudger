<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<style>
    p.normal {font-weight:normal;}
    p.light {font-weight:lighter;}
    p.thick {font-weight:bold;}
    p.thicker {font-weight:900;}
    
    body {background-color:#e0ffff} 

    .container {
        position: relative;
    }

    .center {
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        text-align: center;
        font-size: 18px;
        margin-top:-9px;
    }
    img { 
        width: 100%;
        height: auto;
        opacity: 0.3;
    }

    .problem-list{
        margin-top: 10px;
        
    }

</style>
<div style="float: left; height: 80px; width: 70%;">
    <h1 style="width: 70%;">Welcome to Code Judger</h1>   
</div>

<div style="float: right; height: 80px; width: 30%; margin: auto;">
    <center><b>Not registered ?</b> </b><a href="<?php echo base_url('register'); ?>">Register here</a></center><!--for centered text-->
    <center> </b><a href="<?php echo base_url('login'); ?>">Login here</a></center><!--for centered text-->
</div>

<div>
    <img src="/images/coding.jpeg" alt="Norway" width="600" height="400">
    <p class="thicker">A New Way to Learn</p>

    <p class="thick"> Code Judger is a platform to help you enhance your skills, expand your knowledge and prepare for technical interviews </p>
</div>

<div class="problem-list">
    <?php include 'problem_list.php'; ?>
</div>
