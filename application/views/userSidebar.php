<!-- <div class="container">
    <div class="card user-card">
        <div class="sidebar">
            <a id="user" href="<?php echo base_url('user');?>"><?=$_SESSION['user_name']?></a>
            <a href="<?php echo base_url('my_submission')?>">My Submission</a>
            <a href="<?php echo base_url('user/user_logout');?>">Logout</a>
        </div>
    </div>

    <div class="card submission-card">
            <?php include "submission.php"; ?>
    </div>
</div>

<script>
    function show_user_details(username, useremail, role) {
            $("#user-content").html('<div class="form-group row"> \
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
                console.log("Success");
            },
            error: function(data) {
                console.log("Error");
            }
        });
    }

    $( document ).ready(get_user_details);
</script> -->