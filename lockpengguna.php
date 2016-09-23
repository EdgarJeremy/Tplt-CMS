<?php
require_once "engine/init.php";
if(isset($_GET["id"])) {
	$lock = $pengguna->lock($_GET["id"]);
	if($lock === true) {
		$helper->set_flashdata("green","Pengguna berhasil diblokir!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat memblokir pengguna!");
	}
	$helper->buatLog("Lock Pengguna","Pengguna dengan nama ".$pengguna->ambilNama($_GET["id"])." diblokir oleh ".$_SESSION["nama_lengkap"]." pada ".date("d - M - Y h:i"));
	header("location: daftarpengguna");
	exit();
} else {
	$helper->set_flashdata("red","Pengguna belum dipilih!");
	header("location: daftarpengguna");
	exit();
}
