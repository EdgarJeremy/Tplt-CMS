<!doctype html>
<html>
	<head>
		<!-- CodeMirror -->
		<script src="codemirror/lib/codemirror.js"></script>
		<link rel="stylesheet" href="codemirror/lib/codemirror.css">
		<script src="codemirror/mode/javascript/javascript.js"></script>
		</script>
		<script type="text/javascript" src="codemirror/mode/css/css.js"></script>
	</head>
	<body>
		<textarea id="ubah"></textarea>
	</body>
	<script>
		/* var myCodeMirror = CodeMirror(document.getElementById("ubah"), {
		  value: "function myScript(){return 100;}\n",
		  mode:  "javascript",
		  lineNumbers: true
		}); */
		var myTextArea = document.getElementById("ubah");
		var myCodeMirror = CodeMirror.fromTextArea(myTextArea,{
			mode: "css",
			lineNumbers: true
		});
	</script>
</html>