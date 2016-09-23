<?php
require_once "engine/init.php";
if(isset($_GET["id"])) {
	
	$helper->logged_out_protect();
	$hapus = $gallery->hapus($_GET["id"]);
	
	if($hapus === true) {
		$helper->set_flashdata("green","Foto berhasil dihapus!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat menghapus foto!");
	}
	header("location: daftarfoto");
	exit();
	
} else {
	$helper->set_flashdata("red","Tidak ada foto yang dipilih!");
	header("location: daftarfoto");
}