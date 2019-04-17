<div class="container">
    <div class="justify-content-center align-items-center">
        <?php
            $Success = $this->session->flashdata('Success');
            $Failed = $this->session->flashdata('Failed');
            if($Success){
            ?>
                <div class="alert alert-success">
                    <?php echo $Success; ?>
                </div>
            <?php
            }
            if($Failed){
            ?>
                <div class="alert alert-danger">
                    <?php echo $Failed; ?>
                </div>
            <?php
            }
        ?>
        <form role="form" method="post" action="<?php echo base_url('contribute/add_problem'); ?>" class="col-12 justify-content-center align-items-center" style="padding-top: 20px;">
            <div class="form-group">
                <label for="problemName">Problem Name</label>
                <input type="text" class="form-control" name="problemName" placeholder="Problem Name" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="testInput">Sample Input</label>
                <textarea class="form-control" name="testInput" rows="5" placeholder="Enter the Input Separated by space"></textarea>
            </div>
            <div class="form-group">
                <label for="testOutput">Sample Output</label>
                <textarea class="form-control" name="testOutput" rows="5" placeholder="Enter the Output"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>