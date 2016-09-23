<?php
require_once "init.php";
$arraySeluruhBulan = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
$arraySampaiBulanIni = array();
$bulanSekarang = (int)date("m");
$dataKunjungan = array();

for($i=0;$i<$bulanSekarang;$i++) {
  $arraySampaiBulanIni[] = $arraySeluruhBulan[$i];
  $dataKunjungan[] = $pengunjung->hitungJumlahDalamBulan($i+1);
}

$jsonData = array(
  "title" => array(
    "text" => "Grafik Kunjungan Website",
    "x" => -20
  ),
  "subtitle" => array(
    "text" => "Statistik kunjungan berdasarkan browser yang digunakan",
    "x" => -20
  ),
  "legend" => array(
    "align" => "right",
    "borderWidth" => 0,
    "layout" => "vertical",
    "verticalAlign" => "middle"
  ),
  "tooltip" => array(
    "valueSuffix" => " Kunjungan"
  ),
  "xAxis" => array(
    "categories" => $arraySampaiBulanIni
  ),
  "yAxis" => array(
    "title" => array(
      "text" => "Kunjungan Per IP"
    ),
    "plotLines" => array(
      array(
        "color" => "#808080",
        "value" => 0,
        "width" => 1
      )
    )
  ),
  "series" => array(
    array(
      "name" => "Google Chrome",
      "data" => $dataKunjungan
    )
  )
);

echo json_encode($jsonData);
