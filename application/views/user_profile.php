<?php
    if(!isset($_SESSION['user_id'])){
        redirect('home');
    }
?>

<title><?=$_SESSION['user_name']?>'s Dashboard CodeJudger</title>

<div class="container">
  <div class="row">
    <div class="col-md-4">
      <table class="table table-bordered table-striped">
        <tr>
            <th colspan="2"><h4 class="text-center">User Info</h3></th>
        </tr>
          <tr>
            <td>User Name</td>
            <td><?php echo $this->session->userdata('user_name'); ?></td>
          </tr>
      </table>
    </div>
  </div>
  <a href="<?php echo base_url('user/user_logout');?>" >  
    <button type="button" class="btn-primary">Logout</button> 
  </a> 

    <?php $this->load->view('submission') ?>

</div>
