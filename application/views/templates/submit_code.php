<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/loader.css">

<div class="language-select">
    <select onchange="change_session()" id="select_language" class="styled-select semi-square gray">
        <?php if ($type == 'cpp') { ?>
            <option value="cpp">C++11</option>
        <?php } else if ($type == 'py2') { ?>
            <option value="py2">Python2</option>
        <?php } else if ($type == 'py3') { ?>
            <option value="py3">Python3</option>
        <?php } else if ($type == 'Java8') { ?>
            <option value="java">Java8</option>
        <?php } else { ?>
            <option value="cpp">C++11</option>
            <option value="py2">Python2</option>
            <option value="py3">Python3</option>
            <option value="java">Java8</option>
        <?php } ?>
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

<!-- <div class="border p-3">
    <h4>Code</h4>
    <pre><code><?=$code?></code></pre>
</div> -->

<script>
editor = ace.edit("code");
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

<pre id="hide_code" style="display: none">
<?=$code?>
</pre>

<script>

<?php if ($code == '') { ?>
    window.onload = change_session();
<?php } else { ?>
    change_lang("<?=$type?>");
    code = $("#hide_code").text();
    console.log(code);
    change_code(code);
<?php } ?>

function change_lang(lang) {
    var lan_mode = language;

    if (language == 'cpp') lan_mode = 'c_cpp';
    if (language == 'py2' || language == 'py3') lan_mode = 'python';

    editor.session.setMode("ace/mode/" + lan_mode);
}

function change_code(code) {
    editor.setValue("");
    editor.insert(code);
    console.log(code);
}

function change_session() {
    var language = document.getElementById('select_language').value;

    change_lang(language);

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
            change_code(code);
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
