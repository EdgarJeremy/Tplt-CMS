<?php
require_once "engine/init.php";
$stat = $pengguna->updateDataUser($_SESSION["idusers"],$_POST["username"],$_POST["nama_lengkap"],$_POST["email"],$_POST["password"]);

if($stat == true) {
	$helper->set_flashdata("green","Data user berhasil diupdate!");
	$_SESSION["username"] = $_POST["username"];
	$_SESSION["nama_lengkap"] = $_POST["nama_lengkap"];
	$_SESSION["email"] = $_POST["email"];
	header("location: ".$_POST["currFile"]);
} else {
	$helper->set_flashdata("red","Terjadi kesalahan saat mengupdate data!");
	header("location: ".$_POST["currFile"]);
}
