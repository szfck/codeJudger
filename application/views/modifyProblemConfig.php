<?php include 'contribute.php' ?>

<div class="content">
    <div class="container">
        <div class="justify-content-center align-items-center">
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
            <form role="form" method="post" class="col-12 justify-content-center align-items-center" style="padding-top: 20px;">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Problem</label>
                    </div>
                    <select class="form-control" id="problem" name="problemName">
                        <option selected>Choose Problem ...</option>
                        <?php include 'problem_list_for_skeleon.php'; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="problemDesc">Problem Description</label>
                    <textarea class="form-control" readonly="readonly" id="problemDesc" name="problemDesc" rows="6" placeholder="Problem Description"></textarea>
                </div>
                <div class="form-group">
                    <label for="problemDesc">Sample Input</label>
                    <textarea class="form-control" readonly="readonly" id="sampleInput" name="sampleInput" rows="2" placeholder="Enter the Sample Input Separated by space"></textarea>
                </div>
                <div class="form-group">
                    <label for="problemDesc">Sample Output</label>
                    <textarea class="form-control" readonly="readonly" id="sampleOutput" name="sampleOutput" rows="2" placeholder="Enter the Sample Output"></textarea>
                </div>
                <div class="form-group">
                    <label for="problem-config">Problem Configuration</label>
                    <div id="config"></div>
                </div>
                
                <button id="submit-button" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    var testcase_val = 0
    function show_problem_config(config) {
        console.log(config);
        $("#config").html(' <div class="form-group row"> \
                            <label class="col-sm-2 col-form-label">'+'TestCase'+' : </label> \
                            <div class="col-sm-10"> \
                                <input type="text" class="form-control"  id="testcase" placeholder="'+config.testcase+'" readonly> \
                            </div> \
                            </div> \
                            <div class="form-group row"> \
                            <label class="col-sm-2 col-form-label">'+'TimeLimit'+' : </label> \
                            <div class="col-sm-10"> \
                                <input type="text" class="form-control"  id="timelimit" placeholder="'+config.timelimit+'"> \
                            </div> \
                            </div> \ ');
    }

    $( "#problem" ).change(function() {
        var problem_name = document.getElementById('problem').value;
        $.ajax({
            type: "POST",
            url: "<?=base_url('contribute/get_problem_config')?>",
            crossDomain: true,
            data: {
                problem: problem_name
            },
            dataType: "json",
            success: function(data, status, xhr) {
                testcase_val = data.testcase;
                show_problem_config(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    });


    $("#submit-button").click(function() {
        problemName = document.getElementById("problem").value;
        timelimit = document.getElementById("timelimit").value;
        testcase = testcase_val;
        $.ajax({
            type: "POST",
            url: "<?=base_url('contribute/update_config_file')?>",
            crossDomain: true,
            data: {
                problem: problemName,
                timelimit: timelimit,
                testcase: testcase,
            },
            dataType: "json",
            success: function(data, status, xhr) {
                console.log(data);
                console.log("Success");
            },
            error: function(data) {
                console.log("Error");
                console.log(data);
            }
        });
    });
</script>