<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/problem.css">

<div class="container">

    <div class="problem-statement">
        <div class="header">
            <h2><?=ucfirst($problem_name)?></h2>
            <div>
                time limit per test: <?=$time_limit?> second
            </div>
        </div>
        <div>
            <pre><?=$desc?></pre>
        </div>

        <div class="sample-tests">
            <div class="sample-test">
                <div class="input">
                    <h4>Input</h4>
                    <pre><?=$sample_input?></pre>
                </div>
                <div class="output">
                    <h4>Output</h4>
                    <pre><?=$sample_output?></pre>
            </div>
        </div>
    </div>

    <div class="language-select">
        <select onchange="change_session()" id="select_language" class="styled-select semi-square gray">
            <option value="cpp">C++11</option>
            <option value="py2">Python2</option>
            <option value="py3">Python3</option>
            <option value="java">Java8</option>
        </select>
    </div>
    <div>
        <pre id="code" class="ace_editor" style="min-height:500px"><textarea class="ace_text-input">
                </textarea></pre>

        <button type="button" class="btn btn-primary" style="margin-top: 20px; margin-bottom: 20px;"
            onclick=submit()>Submit</button>
    </div>

    <div class="spinner" id="loader">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
    <div class="mt-5" id="result"></div>

</div>


<script>
editor = ace.edit("code");
// theme = "monokai";
theme = "twlight";
language = "c_cpp";
editor.setTheme("ace/theme/" + theme);
editor.session.setMode("ace/mode/" + language);

editor.setFontSize(15);

editor.setReadOnly(false);

editor.setOption("wrap", "free")

ace.require("ace/ext/language_tools");
editor.setOptions({
    enableBasicAutocompletion: true,
    enableSnippets: true,
    enableLiveAutocompletion: true
});
</script>

<script>
window.onload = change_session();

function change_session() {
    var language = document.getElementById('select_language').value;
    var lan_mode = language;

    if (language == 'cpp') lan_mode = 'c_cpp';
    if (language == 'py2' || language == 'py3') lan_mode = 'python';

    editor.session.setMode("ace/mode/" + lan_mode);
    console.log("<?=$problem_name?>", language);
    var code;
    $.ajax({
        type: "POST",
        url: "<?=base_url('skeleton/get_skeleton_code')?>",
        crossDomain: true,
        data: {
            problem: "<?=$problem_name?>",
            type: language
        },
        success: function(skeleton_code) {
            code = skeleton_code;
            editor.setValue("");
            editor.insert(code);
            console.log(skeleton_code);
        },
        error: function(data) {
            $("#loader").hide();
            console.log(data);
        }
    });

}

function submit() {
    $("#result").hide();
    var language = document.getElementById('select_language').value;
    var code = editor.getValue();
    $("#loader").show();
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
            location.href = '/submission/detail/' + sub_id; // redirect to submission detail page
        },
        error: function(data) {
            $("#loader").hide();
            console.log(data);
            location.href = '/login'; // redirec to login page
        }
    });
}
</script>

<script>
// Show an element
var show = function(elem) {
    elem.css.display = 'block';
};

// Hide an element
var hide = function(elem) {
    elem.css.display = 'none';
};

$("#loader").hide();
</script>
