<?php include 'contribute.php' ?>

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
        <div id="problem-container" class="justify-content-center align-items-center">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Problem</label>
                </div>
                <select class="form-control" id="problem" name="problemName">
                    <option selected>Choose Problem ...</option>
                    <?php include 'problem_list_for_skeleon.php'; ?>
                </select>
            </div>
            <form role="form" method="post" class="col-12 justify-content-center align-items-center" style="padding-top: 20px;">
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
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Language</label>
                    </div>
                        <select id="language" class="form-control language">
                            <option selected>Choose...</option>
                            <option value="cpp">Cpp</option>
                            <option value="py3">Python 3</option>
                            <option value="py2">Python 2</option>
                            <option value="java">Java 8</option>
                        </select>
                    </div>
                <div class="form-group">
                    <label for="skeletonCode">Skeleton Code</label>
                    <textarea class="form-control" id="skeletonCode" rows="15" placeholder="#Skeleton Code"></textarea>
                </div>
                <button id="submit-button" type="submit" class="btn btn-primary" >Submit</button>
            </form>
        </div>
    </div>
</div>


<script>
    $( "#problem" ).change(function() {
        var problem_name = document.getElementById('problem').value;
        $.ajax({
            type: "POST",
            url: "<?=base_url('contribute/get_problem_details')?>",
            crossDomain: true,
            data: {
                problem: problem_name
            },
            dataType: "json",
            success: function(data, status, xhr) {
                desc = data["problem_desc"];
                input = data["problem_input"];
                output = data["problem_output"];
                document.getElementById("problemDesc").value = desc;
                document.getElementById("sampleInput").value = input;
                document.getElementById("sampleOutput").value = output;
                document.querySelectorAll("#problemDesc ,#sampleInput ,#sampleOutput").readOnly = true;
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $( "#language" ).change(function() {
        problemName = document.getElementById('problem').value;
        language = document.getElementById("language").value;
        $.ajax({
            type: "POST",
            url: "<?=base_url('contribute/get_skeleton_code')?>",
            crossDomain: true,
            data: {
                problem: problemName,
                language: language,
            },
            dataType: "json",
            success: function(data, status, xhr) {
                document.getElementById("skeletonCode").value = data;
                console.log(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $("#submit-button").click(function() {
        problemName = document.getElementById("problem").value;
        skeletonCode = document.getElementById("skeletonCode").value;
        language = document.getElementById("language").value;
        console.log(problemName);
        console.log(skeletonCode);
        console.log(language);
        $.ajax({
            type: "POST",
            url: "<?=base_url('contribute/add_skeleton_code')?>",
            crossDomain: true,
            data: {
                problem: problemName,
                code: skeletonCode,
                language: language,
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
