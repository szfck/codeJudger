<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.6/socket.io.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/detail.css">

<script type="text/javascript" charset="utf-8">
var socket = io.connect('http://' + document.domain + ':3000');
socket.on('connect', function() {
    console.log('connected');
    socket.emit('judge', "<?=$sub->subid?>");
});

// status
const PENDING = 'Pending';
const COMPILING = 'Compiling';
const JUDGING = 'Judging';
const ACCEPTED = 'Accepted';
const WRONG_ANSWER = 'Wrong Answer';
const COMPILE_ERROR = 'Compile Error';
const TIME_LIMIE_EXCEED = 'Time Limit Exceed';
const RUNTIME_ERROR = 'Runtime Error';
const UNKNOWN_ERROR = 'Unknown Error';

// {
//     "status": "Accepted",
//     "total_case": "10",
//     "current_case": "10",
//     "error": "",
//     "input": "2719822 7593913\n",
//     "user_output": "10313735\n",
//     "correct_output": "10313735\n"
// }

var case_id = 1;

function addBoxStatus(case_id, status) {
    box_span = '';
    box_icon = '';

    if (status == ACCEPTED) { // accepted
        box_span = 'accepted';
        box_icon = 'glyphicon glyphicon-ok';
    } else if (status == JUDGING) { // currently correct
        box_span = 'accepted';
        box_icon = 'glyphicon glyphicon-ok';
    } else if (status == WRONG_ANSWER || status == COMPILE_ERROR || status == TIME_LIMIE_EXCEED || status ==
        RUNTIME_ERROR || status == UNKNOWN_ERROR) { // wrong
        box_span = 'rejected';
        box_icon = 'glyphicon glyphicon-remove';
    }

    $result_box = $("#case" + case_id);
    $result_box.attr('class', box_span);
    $result_box.children().attr('class', box_icon);
}

function addResultStatus(data) {
    status = data['status'];

    result_td = '';
    result_span = '';

    if (status == ACCEPTED) { // accepted
        result_td = 'status accepted middle';
        result_span = 'glyphicon glyphicon-ok';
    } else if (status == JUDGING) { // currently correct
        result_td = 'status middle';
    } else if (status == WRONG_ANSWER || status == COMPILE_ERROR || status == TIME_LIMIE_EXCEED || status ==
        RUNTIME_ERROR || status == UNKNOWN_ERROR) { // wrong
        result_td = 'status rejected middle';
        result_span = 'glyphicon glyphicon-remove';

        if (status == COMPILE_ERROR) {
            $("#ce_div").css('display', 'block');
            $("#ce_text").text(data['error']);
        } else if (status == RUNTIME_ERROR) {
            $("#re_div").css('display', 'block');
            $("#re_text").text(data['error']);
        } else if (status == WRONG_ANSWER) {
            $("#wa_div").css('display', 'block');
            $("#wa_text_input").text(data['input']);
            $("#wa_text_user_output").text(data['user_output']);
            $("#wa_text_correct_output").text(data['correct_output']);
        }
    } else {
        result_td = 'status middle';
    }
    $("#result_td").attr('class', result_td);
    $("#result_span").attr('class', result_span);
    $("#result_text").html(status);
    $("#run_time").html(data['run_time'] + ' s');
}

socket.on('judge', function(data) {
    console.log('recv from judge');
    console.log(data);

    total_case = data['total_case'];
    current_case = data['current_case'];

    for (; case_id <= current_case; case_id++) {
        if (case_id < current_case) { // for history result, current_case means last case to fail or accept
            addBoxStatus(case_id, ACCEPTED);
        } else {
            addBoxStatus(case_id, data['status']);
        }
    }

    addResultStatus(data);

});
</script>

<div class="container">
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
                    <th class="nowrap" colspan="5">Test cases</th>
                </tr>
            </thead>
            <tbody>
                <tr data-submission-id="<?=$sub->subid?>">

                    <td class="submission_id cell-bottom-left" rowspan="2" data-type="id">
                        <a href="/submission/detail/<?=$sub->subid?>">
                            <?=$sub->subid?>
                        </a>
                    </td>

                    <td class="middle" data-type="time">
                        <?=date("Y-m-d H:i:s", $sub->time)?>
                    </td>

                    <td class="middle" id="problem_title">
                        <a href="/problem/<?=$sub->problem?>">
                            <?=ucfirst($sub->problem)?>
                        </a>
                    </td>

                    <td id="result_td" data-type="status">
                        <span id="result_span">
                            <i></i>
                            <span id="result_text"></span>
                        </span>
                        <!-- <span class="rejected">
                            <i class="glyphicon glyphicon-remove"></i>
                            <span id="status"></span>
                        </span> -->
                    </td>

                    <td class="runtime middle" data-type="cpu">
                        <span id="run_time"></span>
                    </td>

                    <td class="middle" data-type="lang">
                        <?=$sub->type?>
                    </td>

                </tr>

                <tr data-submission-id="<?=$sub->subid?>">
                    <td class="middle cell-bottom-right" colspan="5" data-type="testcases">
                        <div class="testcases">
                            <?php
                                for ($case_id = 1; $case_id <= $testcase; $case_id++) {
                                    echo "
                                        <span id='case$case_id'>
                                            <i></i>
                                        </span>
                                    ";
                                }
                            ?>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </section>

    <section class="box clearfix main-content">

        <div id='ce_div' style="display: none" class="extrainfo">
            <h3>Compiler output</h3>
            <pre id='ce_text'></pre>
        </div>

        <div id='re_div' style="display: none" class="extrainfo">
            <h3>Runtime Error</h3>
            <pre id='re_text'></pre>
        </div>

        <div id='wa_div' style="display: none" class="extrainfo">
            <h3>Failed Case</h3>

            <h4>Input</h4>
            <pre id='wa_text_input'></pre>

            <h4>Your Output</h4>
            <pre id='wa_text_user_output'></pre>

            <h4>Correct Output</h4>
            <pre id='wa_text_correct_output'></pre>
        </div>

        <?php 
            $content = array(
                'problem_name' => $sub->problem,
                'type' => $sub->type,
                'code' => $code
            );
            $this->load->view('/templates/submit_code', $content);
        ?>

    </section>

</div>