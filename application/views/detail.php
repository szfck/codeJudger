<script type="text/javascript" charset="utf-8">
    var socket = io.connect('http://' + document.domain + ':3000');
    socket.on('connect', function() {
        console.log('connected');
        socket.emit('judge', "<?=$subid?>");
    });
    socket.on('judge', function(data) {
        console.log('recv from judge');
        console.log(data);
        // socket.emit('my event', {data: 'I\'m connected!'});
    });
</script>

<!-- <script>
function judge() {
    $.ajax({
        type: "POST",
        url: "<?=base_url('submission/submit')?>",
        crossDomain: true,
        data: {
            problem: "<?=$problem_name?>",
            code: code,
            type: language
        },
        dataType: "json",
        success: function(data, status, xhr) {                 
            $("#loader").hide();
            console.log(data);
            sub_id = data;
            location.href = '/submission/detail/' + sub_id;

            // res = data["status"];
            // totalcase = data["total_case"];
            // correctcase = data["correct_case"];
            // input = data["input"];
            // output = data["user_output"];
            // expected_output = data["correct_output"];
            // error = data["error"];

            // if (res == "Accepted") {
            //     html_to_append("success", data);
            // } else if (res == "Compile Error") {
            //     html_to_append("warning", data);
            // } else if (res == "Wrong Answer") {
            //     html_to_append("danger", data);
            // } else if (res == "Time Limit Exceed") {
            //     html_to_append("secondary", data);
            // } else if (res == "Runtime Error") {
            //     html_to_append("danger", data);
            // } else {
            //     html_to_append("light", data);
            // }
        },
        error: function(data) {
            console.log(data);
        }
    });
} -->
<!-- </script> -->

<div class="border p-3">
    <pre><code><?=$code?></code></pre>
</div>

<section class="box clearfix main-content">
    <div class="page-headline clearfix" style="padding-bottom: 8px">
        <div class="fl">
            <h1>Submission</h1>
        </div>
    </div>

    <table id="judge_table" class="table table-responsive table-kattis table-hover table-rowspan">
        <thead>
            <tr>
                <th class="nowrap submission_id" rowspan="2">ID</th>
                <th class="nowrap">Date</th>
                <th class="nowrap">Problem</th>
                <th class="nowrap">Status</th>
                <th class="nowrap runtime">CPU</th>
                <th class="nowrap">Lang</th>
            </tr>
            <tr>
                <th class="nowrap" colspan="5">Test cases</th></tr>
        </thead>
        <tbody>
            <tr data-submission-id="3776128"><td class="submission_id cell-bottom-left" rowspan="2" data-type="id"><a href="/submissions/3776128">3776128</a></td><td class="middle" data-type="time">2019-02-09 02:51:30</td><td class="middle" id="problem_title"><a href="/problems/aplusb">A+B Problem</a></td><td class="status rejected middle" data-type="status"><span class="rejected"><i class="glyphicon glyphicon-remove"></i>Wrong Answer</span></td><td class="runtime middle" data-type="cpu">0.06&nbsp;s</td><td class="middle" data-type="lang">C++</td></tr>
            <tr data-submission-id="3776128">
                <td class="middle cell-bottom-right" colspan="5" data-type="testcases">
                    <div class="testcases">
                        <span class="accepted" title="Test case 1/22: Accepted">
                            <i class="glyphicon glyphicon-ok"></i>
                        </span>
                        <span class="accepted" title="Test case 2/22: Accepted">
                            <i class="glyphicon glyphicon-ok"></i>
                        </span>
                        <span class="rejected" title="Test case 3/22: Wrong Answer">
                            <i class="glyphicon glyphicon-remove"></i>
                        </span>
                        <span title="Test case 4/22: not checked">&nbsp;</span>
                        <span title="Test case 5/22: not checked">&nbsp;</span>
                        <span title="Test case 6/22: not checked">&nbsp;</span>
                        <span title="Test case 7/22: not checked">&nbsp;</span>
                        <span title="Test case 8/22: not checked">&nbsp;</span>
                        <span title="Test case 9/22: not checked">&nbsp;</span>
                        <span title="Test case 10/22: not checked">&nbsp;</span>
                        <span title="Test case 11/22: not checked">&nbsp;</span>
                        <span title="Test case 12/22: not checked">&nbsp;</span>
                        <span title="Test case 13/22: not checked">&nbsp;</span>
                        <span title="Test case 14/22: not checked">&nbsp;</span>
                        <span title="Test case 15/22: not checked">&nbsp;</span>
                        <span title="Test case 16/22: not checked">&nbsp;</span>
                        <span title="Test case 17/22: not checked">&nbsp;</span>
                        <span title="Test case 18/22: not checked">&nbsp;</span>
                        <span title="Test case 19/22: not checked">&nbsp;</span>
                        <span title="Test case 20/22: not checked">&nbsp;</span>
                        <span title="Test case 21/22: not checked">&nbsp;</span>
                        <span title="Test case 22/22: not checked">&nbsp;</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</section>
