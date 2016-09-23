<?php
require_once "init.php";
$helper->logged_out_protect();
$data = $berita->ambilBerdasarkanId($_GET["id"]);

echo json_encode($data);