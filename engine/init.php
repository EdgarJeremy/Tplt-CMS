<?php
ob_start();
session_start();

$archiver = new ZipArchive;

function autoloader($class) {
	$filename = $class.".php";
	include_once $filename;
}

spl_autoload_register("autoloader");

try {
	$database = new database();
	$helper = new helper();
	$pengguna = new pengguna($helper);
	$berita = new berita($helper);
	$agenda = new agenda();
	$gallery = new gallery($helper);
	$tema = new tema();
	$infoweb = new infoweb();
	$importer = new importer($archiver);
	$pengunjung = new pengunjung($helper);
} catch (Exception $e) {
	echo $e->getMessage()."\n";
	exit();
}
