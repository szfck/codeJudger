
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.3/ace.js" type="text/javascript" charset="utf-8"></script>

<div class="container"><br>
	<p class="problem problem-name"><?php echo $problem_number.". ".$problem_name;?></p><br>
    <p ><strong>Problem Description</strong></p>
    <p class="problem problem-desc"><?php echo $desc;?></p><br>
    <p ><strong>Sample Input</strong></p>
    <p class="problem problem-sample_input"><?php echo $sample_input;?></p><br>
    <p ><strong>Sample Output</strong> </p>
    <p class="problem problem-sample_output"><?php echo $sample_output;?></p><br>
</div>
<div class="container language-select">
	<select onchange="change_session()" id="select_language" class="styled-select semi-square gray">
		<option value="javascript">javascript</option>
		<option value="python">python</option>
		<option value="java">java</option>
		<option value="c">c</option>
	</select>	
</div><br>

<div id="editor" class="container" style="height: 300px; padding-right: 50px;"></div>

<script>
	var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    document.getElementById('editor').style.fontSize='17px';
    editor.insert("Hello World !!");
	var language = 'javascript';
	editor.session.setMode("ace/mode/"+language);
	function change_session(){
		var language = document.getElementById('select_language').value;
		editor.session.setMode("ace/mode/"+language);
	}
	console.log(language);
</script>