<?php
require_once "init.php";
$helper->logged_out_protect();

echo $tema->ambilIsi($_GET["css"]);