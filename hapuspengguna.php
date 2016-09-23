<?php
require_once "engine/init.php";
if(isset($_GET["id"])) {
	$hapus = $pengguna->hapus($_GET["id"]);
	if($hapus === true) {
		$helper->set_flashdata("green","Pengguna berhasil dihapus!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat menghapus pengguna!");
	}
	header("location: daftarpengguna");
	exit();
} else {
	$helper->set_flashdata("red","Pengguna belum dipilih!");
	header("location: daftarpengguna");
	exit();
}
