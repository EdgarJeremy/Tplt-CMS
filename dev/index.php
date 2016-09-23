<!DOCTYPE HTML>
<html>
	<head>
		<title>Button</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<button class="awesome" id="button">
			<span class="bars">
			</span>
			<span class="bars">
			</span>
			<span class="bars">
			</span>
		</button>
		<script>
			var button = document.getElementById("button");
			button.onclick = function() {
				if(button.className == "awesome") {
					this.classList.add("click");
				} else {
					this.classList.remove("click");
				}
			}
		</script>
	</body>
</html>