<?php
require_once "engine/init.php";
$helper->logged_out_protect();
$menu = $helper->tentukan_menu_aktif("","agendaChild","daftaragenda");
$title = "Daftar Agenda - Administrator";
include "frames/menu.php";
?>
			<div class="content">
				<?php $helper->get_notif();?>
				<div class="main-box">
					<div class="header">
						<h1>Daftar Agenda</h1>
					</div>
					<div class="contain card">
						<table id="daftarberita" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Judul</th>
									<th>Tanggal</th>
									<th>Mulai</th>
									<th>Selesai</th>
									<th>Deskripsi</th>
									<th>Tutup</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Judul</th>
									<th>Tanggal</th>
									<th>Mulai</th>
									<th>Selesai</th>
									<th>Deskripsi</th>
									<th>Tutup</th>
								</tr>
							</tfoot>
							<tbody>
								<?php
									$data = $agenda->ambil();
									$i=1;
									if($data != false):
									foreach($data as $agd):
								?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $agd["judul"];?></td>
									<td><?php echo $agd["tanggal"];?></td>
									<td><?php echo $agd["mulai"];?></td>
									<td><?php echo $agd["selesai"];?></td>
									<td><?php echo $agd["deskripsi"];?></td>
									<td style="text-align: center"><button type="button" class="btn red btnHapus" data-name="<?php echo $agd["judul"];?>" data-id="<?php echo $agd["idagenda"];?>"><span style="color: white" class="fa fa-close fa-lg"></span></button></td>
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

		<div class="overlay ag">
			<div class="popup-body ag">
				<div class="contain card">
					<div class="head">
						<span class="fa fa-close fa-lg" id="close"></span>
						<div class="icn">
							<i class="fa fa-exclamation-circle fa-lg"></i>
						</div>
						<h1>Apakah anda yakin?</h1><hr />
						<p>Anda akan menghapus agenda dengan judul <span id="judul"></span></p>
					</div>
					<div class="input-group">
						<button id="confirm" class="btn red"><i class="fa fa-trash fa-lg"></i>&nbsp;Hapus</button> <button id="batal" class="btn blue"><i class="fa fa-chevron-circle-left fa-lg"></i>&nbsp;Batal</button>
					</div>
				</div>
			</div>
		</div>

		<script>
		$(document).ready(function(){
			$("#daftarberita").DataTable();

			// fungsi2 native
			function hapus(id) {
				window.location.href = "hapusagenda?id=" + id;
			}
			function openPopup(nama,id) {
				$(".overlay.ag").fadeIn(100);
				$(".popup-body.ag").slideDown(300);
				$("#judul").html(nama).fadeIn(700);
				$("#confirm").click(function(){
					hapus(id);
				});
			}
			function closePopup() {
				$(".overlay.ag").fadeOut(100);
				$(".popup-body.ag").slideUp(300);
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
			//escape
			$(document).on("keyup",function(ev){
				if(ev.keyCode == 27) {
					closePopup();
				}
			});
			$(".popup-body").draggable({revert: true});

		});
		</script>

<?php include "frames/footer.php";?>
