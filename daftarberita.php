<?php
require_once "engine/init.php";
$helper->logged_out_protect();
$menu = $helper->tentukan_menu_aktif("","beritaChild","daftarberita");
$title = "Daftar Berita - Administrator";
include "frames/menu.php";
?>
			<div class="content">
				<?php $helper->get_notif();?>
				<div class="main-box">
					<div class="header">
						<h1>Daftar Berita</h1>
					</div>
					<div class="contain card">
						<table id="daftarberita" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Judul</th>
									<th>Ringkasan</th>
									<th>Penulis</th>
									<th>Waktu Publish</th>
									<th>Hapus</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Judul</th>
									<th>Ringkasan</th>
									<th>Penulis</th>
									<th>Waktu Publish</th>
									<th>Hapus</th>
								</tr>
							</tfoot>
							<tbody>
								<?php
								$data = $berita->ambil();
								$i=1;
								if($data != false):
								foreach($data as $news):?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $helper->batas_kata($news["judul"],5);?></td>
									<td><?php echo $helper->batas_kata($news["isi"],5);?></td>
									<td><?php echo $news["nama_lengkap"];?></td>
									<td><?php echo $helper->format_waktu($news["waktu"]);?></td>
									<td style="text-align: center"><button type="button" class="btn red btnHapus" data-name="<?php echo $news["judul"];?>" data-id="<?php echo $news["idberita"];?>"><span style="color: white" class="fa fa-trash fa-lg"></span></button></td>
								</tr>
								<?php
								$i++;endforeach;
								endif;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="overlay" id="popupHapus">
			<div class="popup-body">
				<div class="contain card">
					<div class="head">
						<span class="fa fa-close fa-lg" id="close"></span>
						<div class="icn">
							<i class="fa fa-exclamation-circle fa-lg"></i>
						</div>
						<h1>Apakah anda yakin?</h1><hr />
						<p>Anda akan menghapus berita dengan judul <br /><span id="judul"></span></p>
					</div>
					<div class="input-group">
						<button id="confirm" class="btn red"><i class="fa fa-trash fa-lg"></i>&nbsp;Hapus</button> <button id="batal" class="btn blue"><i class="fa fa-chevron-circle-left fa-lg"></i>&nbsp;Batal</button>
					</div>
				</div>
			</div>
		</div>
		<script>
		$(document).ready(function(){

			// Inisialisasi datatable
			$("#daftarberita").DataTable();

			// fungsi2 native
			function hapus(id) {
				window.location.href = "hapusberita?id=" + id;
			}
			function openPopup(nama,id) {
				$(".overlay#popupHapus").fadeIn(100);
				$("#popupHapus .popup-body").slideDown(300);
				$("#judul").html(nama).fadeIn(700);
				$("#confirm").click(function(){
					hapus(id);
				});
			}
			function closePopup() {
				$(".overlay").fadeOut(100);
				$(".popup-body").slideUp(300);
			}

			// trigger element
			$(".btnHapus").on("click",function() {
				var nama = $(this).data("name"),
					id = $(this).data("id");
				openPopup(nama,id);
			});
			$("#close").on("click",closePopup);
			$("#batal").on("click",closePopup);
			$("#alert").on("click",function(){
					$(this).fadeOut(100);
			});
			$(".popup-body").draggable({revert: true});
			//escape
			$(document).on("keyup",function(ev){
				if(ev.keyCode == 27) {
					closePopup();
				}
			});

		});
		</script>

<?php include "frames/footer.php";?>
