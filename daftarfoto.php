<?php
require_once "engine/init.php";
$helper->logged_out_protect();
$menu = $helper->tentukan_menu_aktif("","galleryChild","daftarfoto");
$title = "Daftar Foto - Administrator";
include "frames/menu.php";
?>
			<div class="content">
				<?php $helper->get_notif();?>
				<div class="main-box">
					<div class="header">
						<h1>Daftar Foto</h1>
					</div>
					<div class="contain card" id="gal">
						<div class="wrapper">
							<div class="tatenga">
								<?php
								$i = 0;
								$picts = $gallery->ambil();
								if($picts != false):
								foreach($picts as $gambar):
								?>
								<div class="box gal">
									<img class="btnPreview list-gambar" title="<?php echo $gambar["deskripsi"];?>" src="../img/gallery/thumbs/thumb_<?php echo $gambar["nama_gambar"];?>" data-nama="<?php echo $gambar["nama_gambar"];?>"/>
									<div class="act">
										<b>Caption :</b> <?php echo $gambar["deskripsi"];?><br />
										<b>Diupload oleh : </b><?php echo $gambar["nama_lengkap"];?><br />
										<b>Pada : </b><?php echo $helper->format_waktu($gambar["waktu"]);?><hr />
										<button type="button" class="btn red btnHapus" data-name="<?php echo $gambar["deskripsi"];?>" data-id="<?php echo $gambar["idgallery"];?>"><i class="fa fa-trash fa-lg"></i>&nbsp;Hapus</button>&nbsp;&nbsp;<button type="button" data-nama="<?php echo $gambar["nama_gambar"];?>" class="btn green btnPreview"><i class="fa fa-eye fa-lg"></i>&nbsp;Preview</button>
									</div>
								</div>
								<?php endforeach;else:
								echo "<h2>Tidak ada foto yang diupload untuk sekarang ini!</h2><hr />
								<a href='tambahfoto' class='btn green'><i class='fa fa-upload fa-lg'></i>&nbsp;Mulai upload foto</a>";endif;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Popups -->
		<div class="overlay" id="deleteConfirm">
			<div class="popup-body">
				<div class="contain card">
					<div class="head">
						<span class="fa fa-close fa-lg" id="close"></span>
						<div class="icn">
							<i class="fa fa-exclamation-circle fa-lg"></i>
						</div>
						<h1>Apakah anda yakin?</h1><hr />
						<p>Anda akan menghapus foto dengan judul <span id="judul"></span></p>
					</div>
					<div class="input-group">
						<button id="confirm" class="btn red"><i class="fa fa-trash fa-lg"></i>&nbsp;Hapus</button> <button id="batal" class="btn blue"><i class="fa fa-chevron-circle-left fa-lg"></i>&nbsp;Batal</button>
					</div>
				</div>
			</div>
		</div>
		<div class="overlay" id="preview">
			<span class="fa fa-close fa-lg" id="closePreview"></span>
			<div class="popup-body" id="nsd">
				<img src="" id="popup"/>
			</div>
		</div>


		<script>
			$(document).ready(function(){
				// fungsi2 native
				function hapus(id) {
					window.location.href = "hapusfoto?id=" + id;
				}
				function openPopup(nama,id) {
					$(".overlay#deleteConfirm").fadeIn(100);
					$(".popup-body").slideDown(300);
					$("#judul").html(nama).fadeIn(700);
					$("#confirm").click(function(){
						hapus(id);
					});
				}
				function openPreview(nama) {
					$(".overlay#preview").fadeIn(100);
					$(".popup-body").slideDown(100);
					$(".popup-body img").attr("src","../img/gallery/" + nama).slideDown(300);
					$("body").addClass("filter");
					$("#bijon").addClass("bungkus");
					$("#popup").draggable({revert:true});
				}
				function closePopup() {
					$(".overlay").fadeOut(100);
					$(".popup-body").slideUp(300);
					$("body").removeClass("filter");
					$("#bijon").removeClass("bungkus");
				}

				//trigger element
				$(".btnHapus").on("click",function(){
					var nama = $(this).data("name"),
						id = $(this).data("id");
					openPopup(nama,id);
				});
				$(".btnPreview").on("click",function() {
					var nama_gambar = $(this).data("nama");
					openPreview(nama_gambar);
				});
				$(".popup-body").draggable({revert: true});
				//escape
				$(document).on("keyup",function(ev){
					if(ev.keyCode == 27) {
						closePopup();
					}
				});


				$("#close").on("click",closePopup);
				$("#closePreview").on("click",closePopup);
				$("#batal").on("click",closePopup);
				$("#alert").on("click",function(){
					$(this).fadeOut(100);
				});


			});
		</script>

<?php include "frames/footer.php";?>
