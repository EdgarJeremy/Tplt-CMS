<?php
if(isset($_POST["daftar"])) {
	$isidaftar = $_POST["daftar"];
	
	var_dump(file_put_contents("../frames/listbox.php",$isidaftar));
}