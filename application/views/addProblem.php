<div class="container">
    <?php
        $success_msg= $this->session->flashdata('Success');
        $message = $this->session->flashdata('message');
        $error_msg= $this->session->flashdata('Failed');
        if($success_msg){
        ?>
        <div class="alert alert-success">
            <?php echo $success_msg; ?>
            <?php echo $message; ?>
        </div>
        <?php
        }
        if($error_msg){
        ?>
        <div class="alert alert-danger">
            <?php echo $error_msg; ?>
        </div>
        <?php
        }
    ?>
    <div class="justify-content-center align-items-center">
        <form role="form" method="post" action="<?php echo base_url('contribute/add_problem'); ?>" class="col-12 justify-content-center align-items-center" style="padding-top: 20px;">
            <div class="form-group">
                <label for="problemName">Problem Name</label>
                <input type="text" class="form-control" name="problemName" placeholder="Problem Name" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="problemDesc">Problem Description</label>
                <textarea class="form-control" name="problemDesc" rows="12" placeholder="Problem Description"></textarea>
            </div>
            <div class="form-group">
                <label for="problemDesc">Sample Input</label>
                <textarea class="form-control" name="sampleInput" rows="3" placeholder="Enter the Sample Input Separated by space"></textarea>
            </div>
            <div class="form-group">
                <label for="problemDesc">Sample Output</label>
                <textarea class="form-control" name="sampleOutput" rows="2" placeholder="Enter the Sample Output"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>