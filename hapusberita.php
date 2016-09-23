<?php
require_once "engine/init.php";
if(isset($_GET["id"])) {

	$helper->logged_out_protect();
	$helper->buatLog("Penghapusan Berita","Berita dengan judul ".$berita->ambilNama($_GET["id"])." dihapus oleh ".$_SESSION["nama_lengkap"]);
	$hapus = $berita->hapus($_GET["id"]);

	if($hapus === true) {
		$helper->set_flashdata("green","Berita berhasil dihapus!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat menghapus berita!");
	}
	header("location: daftarberita");
	exit();
	
} else {
	$helper->set_flashdata("red","Tidak ada berita yang dipilih!");
	header("location: daftarberita");
}
