<?php
    if(!isset($_SESSION['user_id'])){
        redirect('home');
    }
?>
<?php include "userSidebar.php" ?>
<div class="content">
    <div class="container">
        <?php
        $success_msg= $this->session->flashdata('Success');
        $error_msg= $this->session->flashdata('Failed');
        if($success_msg){
        ?>
        <div class="alert alert-success">
            <?php echo $success_msg; ?>
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
        <div id="user-content"></div>
    </div>
    
</div>

<script>
    function show_user_details(username, useremail, role) {
        $("#user-content").html(' <div class="form-group row"> \
                            <label class="col-sm-2 col-form-label">UserName : </label> \
                            <div class="col-sm-10"> \
                                <input type="text" class="form-control"  id="testcase" placeholder="'+username+'" readonly> \
                            </div> \
                        </div> \
                        <div class="form-group row"> \
                            <label class="col-sm-2 col-form-label">UserEmail : </label> \
                            <div class="col-sm-10"> \
                                <input type="text" class="form-control"  id="testcase" placeholder="'+useremail+'" readonly> \
                            </div> \
                        </div> \
                        <div class="form-group row"> \
                            <label class="col-sm-2 col-form-label">Role : </label> \
                            <div class="col-sm-10"> \
                                <input type="text" class="form-control"  id="testcase" placeholder="'+role+'" readonly> \
                            </div> \
                        </div> \ ');
    }

    function get_user_details(){
        user = $("#user").text();
        console.log(user);
        $.ajax({
            type: "POST",
            url: "<?=base_url('user/get_user_details')?>",
            crossDomain: true,
            data: {
                user: user,
            },
            dataType: "json",
            success: function(data, status, xhr) {
                username = data['username'];
                useremail = data['useremail'];
                role = data['role'];
                show_user_details(username, useremail, role);
                console.log(data);
                console.log("Success");
            },
            error: function(data) {
                console.log("Error");
                console.log(data);
            }
        });
    }

    $( document ).ready(get_user_details);
</script>