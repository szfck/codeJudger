<?php
    if(!isset($_SESSION['user_id'])){
        redirect('home');
    }
?>

<title><?=$_SESSION['user_name']?>'s Dashboard CodeJudger</title>

<div class="container">
  <div class="d-flex flex-row-reverse">
    <div class="p-2">
      <a href="<?php echo base_url('user/user_logout');?>">
        <button type="button" class="btn-primary">Logout</button>
      </a></div>
  </div>
  <?php $this->load->view('submission') ?>
</div>
