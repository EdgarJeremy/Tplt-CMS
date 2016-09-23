<?php
require_once "init.php";
$helper->logged_out_protect();
$helper->admin_area_protect();
if(isset($_POST["btnSubmit"])) {

	if($_POST["nama"] != "" && $_FILES["fileZip"]["name"] != "") {
		$import = $importer->upload($_FILES["fileZip"]);
		if($import === true) {
			$helper->set_flashdata("green","Layout berhasi diimport!");
		} else {
			$helper->set_flashdata("red","Terjadi kesalahan saat mengimport layout!");
		}
		header("location: ../import.php");
	} else {
		echo "<script>
				alert('Semua field harus diisi!');
				window.location.href = '../import?error';
			 </script>";
	}

} else {
	header("Location: ../home");
}

?>
