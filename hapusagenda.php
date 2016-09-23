<?php
require_once "engine/init.php";
if(isset($_GET["id"])) {
	$helper->logged_out_protect();
	$hapus = $agenda->hapus($_GET["id"]);

	if($hapus === true) {
		$helper->set_flashdata("green","Agenda berhasil dihapus!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat menghapus agenda!");
	}
	header("location: daftaragenda");
	exit();

} else {
	$helper->set_flashdata("red","Tidak ada agenda yang dipilih!");
	header("location: daftaragenda");
}
