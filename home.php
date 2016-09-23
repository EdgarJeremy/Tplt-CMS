<?php
require_once "engine/init.php";
$helper->logged_out_protect();
$menu = $helper->tentukan_menu_aktif("home");
$title = "Home - Administrator";
include "frames/menu.php";
?>
		<div class="content">
			<?php $helper->get_notif();?>
			<div class="main-box">
				<div class="header">
					<h1>Selamat Datang, <?php echo explode(" ",$_SESSION["nama_lengkap"])[0];?>!</h1>
					<span class="search">
						<form action="" method="get">
							<input name="q" type="text" placeholder="Cari Fitur.." class="input-text" /><button type="submit" class="btn"><i class="fa fa-search fa-lg"></i></button>
						</form>
					</span>
				</div>
				<div class="contain card" id="gal">
					<div class="row" id="listParent">
						<?php include "frames/listbox.php";?>
					</div>
				</div><br />
				<div class="contain card" id="chart-wrapper">
					<div id="chartPengunjung"></div>
				</div><br />
				<div class="row">
					<div class="col-xs-6">
						<div class="contain card">
						<h2 class="titling">Berita Terbaru</h2>
							<?php
							$list = $berita->ambil(3);
							if($list != false):
							foreach($list as $news):
							?>
							<div class="news-list">
								<h4><a target="_blank" class="bolder" href="../bacaberita?id=<?php echo $news["idberita"];?>"><?php echo $news["judul"];?></a></h4>
								<span class="info">Tanggal <?php echo $helper->format_waktu($news["waktu"]);?></span>
								<div class="sum">
									<?php echo $helper->batas_kata($news["isi"],5);?>
								</div>
							</div>
							<?php endforeach;else:?>
							<h4 class="info">Belum ada berita yang dipublikasi</h4>
							<a href="tambahberita">Tambah sekarang</a>
							<?php endif;?>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="contain card">
						<h2 class="titling">Agenda Terbaru</h2>
							<?php
							$list = $agenda->ambil(3);
							if($list != false):
							foreach($list as $ag):
							?>
							<div class="news-list">
								<h4><a target="_blank" class="bolder" href="#"><?php echo $ag["judul"];?></a></h4>
								<span class="info">Tanggal : <?php echo $ag["tanggal"];?></span><br />
								<span class="info">Mulai Pukul : <?php echo $ag["mulai"];?></span><br />
								<span class="info">Selesai Pukul : <?php echo $ag["selesai"];?></span><hr />
								<div class="sum">
									<?php echo $helper->batas_kata($ag["deskripsi"],10);?>
								</div>
							</div>
							<?php endforeach;else:?>
							<h4 class="info">Belum ada agenda yang dipublikasi</h4>
							<a href="tambahberita">Tambah sekarang</a>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="highcharts/js/highcharts.js" charset="utf-8"></script>
		<script src="highcharts/js/modules/exporting.js" charset="utf-8"></script>
		<script>
			$(document).ready(function(){
				$("#boxes").sortable();
				$("#alert").on("click",function(){
					$(this).fadeOut(100);
				});

				$.ajax({
					method: "get",
					url: "engine/jsonDataPengunjung",
					success: function(responses){
						var jsonData = JSON.parse(responses);
						//console.log(jsonData);
						$("#chartPengunjung").highcharts(jsonData);
					}
				});

				$("#scrollKeChart").on("click",function(){
					var keTarget = $("#chart-wrapper").offset().top - 70;
					var num = 0;
					var content = $(".content");
					var interval = setInterval(function(){
						content.scrollTop(num);
						// if(content.scrollTop() > keTarget - 90) {
						// 	num = num + 1;
						// } else if(content.scrollTop() > keTarget - 80) {
						// 	num = num + 2;
						// } else if(content.scrollTop() > keTarget - 70) {
						// 	num = num + 3;
						// } else {
						// 	num = num + 4;
						// }
						num = num + 6;
						if(content.scrollTop() >= keTarget) {
							clearInterval(interval);
						}
					});
				});

			});
		</script>

<?php include "frames/footer.php"; ?>
