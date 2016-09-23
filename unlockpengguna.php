<?php
require_once "engine/init.php";
if(isset($_GET["id"])) {
	$unlock = $pengguna->unlock($_GET["id"]);
	if($unlock === true) {
		$helper->set_flashdata("green","Pengguna berhasil diaktifkan kembali!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat mengaktifkan pengguna!");
	}
	$helper->buatLog("Unlock Pengguna","Pengguna dengan nama ".$pengguna->ambilNama($_GET["id"])." dibuka akses oleh ".$_SESSION["nama_lengkap"]." pada ".date("d - M - Y h:i"));
	header("location: daftarpengguna");
	exit();
} else {
	$helper->set_flashdata("red","Pengguna belum dipilih!");
	header("location: daftarpengguna");
	exit();
}
