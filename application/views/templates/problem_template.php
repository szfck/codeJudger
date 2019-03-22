
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.3/ace.js" type="text/javascript" charset="utf-8"></script>

<div class="container">
	<p><?php echo $problem_name;?></p><br>
    <p><?php echo $desc;?></p><br>
    <p>Sample Input</p>
    <p><?php echo $sample_input;?></p><br>
    <p>Sample Output</p>
    <p><?php echo $sample_output;?></p><br>
</div>
<div class="container" style="padding-left: 0px;">
	<select onchange="change_session()" id="select_language" >
		<option value="javascript">javascript</option>
		<option value="python">python</option>
		<option value="java">java</option>
		<option value="c">c</option>
	</select>	
</div>


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