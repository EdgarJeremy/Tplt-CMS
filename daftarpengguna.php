<?php
require_once "engine/init.php";
$helper->logged_out_protect();
$helper->admin_area_protect();

if(isset($_POST["btnSubmitEdit"])) {
	$cond = $pengguna->updateDataUserLain($_POST["idusers"],$_POST["username"],$_POST["nama_lengkap"],$_POST["email"],$_POST["password"],$_POST["level"]);
	if($cond === true) {
		$helper->set_flashdata("green","Data pengguna dengan nama ".$_POST["nama_lengkap"]." sudah berhasil diupdate!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat mengupdate data user!");
	}
	$helper->buatLog("Perubahan Data User","Data user ".$_POST["nama_lengkap"]." diubah oleh ".$_SESSION["nama_lengkap"]." pada ".date("d - M - Y h:i"));
	header("location: daftarpengguna");
	exit();
}

$menu = $helper->tentukan_menu_aktif("daftarpengguna");
$title = "Daftar Pengguna - Administrator";
include "frames/menu.php";
?>

			<div class="content">
				<?php $helper->get_notif();?>
				<!-- <div class="alert green">
					<p><i class="fa fa-check-circle"></i>&nbsp;Lorem Ipsum Dolor Sit Amet</p>
				</div> -->
				<div class="main-box">
					<div class="header">
						<h1>Daftar Pengguna</h1>
					</div>
					<div class="contain card">
						<table id="daftarpengguna" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Lengkap</th>
									<th>Username</th>
									<th>Email</th>
									<th>Level</th>
									<th>Status</th>
									<th>Opsi</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Nama Lengkap</th>
									<th>Username</th>
									<th>Email</th>
									<th>Level</th>
									<th>Status</th>
									<th>Opsi</th>
								</tr>
							</tfoot>
							<tbody>
								<?php
								$dataUser = $pengguna->ambil();
								$no = 1;
								foreach($dataUser as $usr):
								?>
								<tr>
									<td><?php echo $no;?></td>
									<td><img class="profile-preview" src="img/fotoprofil/<?php echo $usr["foto_profil"];?>"/>&nbsp;<span class="nm"><?php echo $usr["nama_lengkap"];?></span></td>
									<td><?php echo $usr["username"];?></td>
									<td><?php echo $usr["email"];?></td>
									<td><?php echo $usr["level"];?></td>
									<td><?php echo ($usr["blokir"] == "N") ? "Aktif" : "Blokir";?></td>
									<td>
										<?php
										if($usr["blokir"] == "N"):
										?>
										<button type="button" data-nama="<?php echo $usr["nama_lengkap"];?>" data-id="<?php echo $usr["idusers"];?>" class="btn yellow lock"><i class="fa fa-lock fa-lg"></i></button>
										<?php else:?>
										<button type="button" data-nama="<?php echo $usr["nama_lengkap"];?>" data-id="<?php echo $usr["idusers"];?>" class="btn green unlock"><i class="fa fa-unlock fa-lg"></i></button>
										<?php endif;?>
										<button type="button" data-nama="<?php echo $usr["nama_lengkap"];?>" data-id="<?php echo $usr["idusers"];?>" class="btn red hapus"><i class="fa fa-trash fa-lg"></i></button>
										<button type="button" data-id="<?php echo $usr["idusers"];?>" class="btn blue" onClick="openEditUser('<?php echo $usr["idusers"];?>','<?php echo $usr["username"];?>','<?php echo $usr["nama_lengkap"];?>','<?php echo $usr["email"];?>','<?php echo $usr["level"];?>')"><i class="fa fa-edit fa-lg"></i></button>
									</td>
								</tr>
								<?php $no++;endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="overlay" id="deleteConfirm">
			<div class="popup-body">
				<div class="contain card">
					<div class="head">
						<span class="fa fa-close fa-lg close"></span>
						<div class="icn">
							<i class="fa fa-exclamation-circle fa-lg"></i>
						</div>
						<h1>Apakah anda yakin?</h1><hr />
						<p>Anda akan menghapus pengguna dengan nama <br /><span id="nama"></span></p>
					</div>
					<div class="input-group">
						<button id="confirm" class="btn red"><i class="fa fa-trash fa-lg"></i>&nbsp;Hapus</button> <button class="btn blue batal"><i class="fa fa-chevron-circle-left fa-lg"></i>&nbsp;Batal</button>
					</div>
				</div>
			</div>
		</div>

		<div class="overlay" id="lockConfirm">
			<div class="popup-body">
				<div class="contain card">
					<div class="head">
						<span class="fa fa-close fa-lg close"></span>
						<div class="icn" style="color: #79bbe7">
							<i class="fa fa-info-circle fa-lg"></i>
						</div>
						<h1>Apakah anda yakin?</h1><hr />
						<p>Anda akan memblokir pengguna dengan nama <br /><span id="nama"></span></p>
					</div>
					<div class="input-group">
						<button id="confirmLock" class="btn yellow"><i class="fa fa-lock fa-lg"></i>&nbsp;Blokir</button> <button class="btn blue batal"><i class="fa fa-chevron-circle-left fa-lg"></i>&nbsp;Batal</button>
					</div>
				</div>
			</div>
		</div>

		<div class="overlay" id="unlockConfirm">
			<div class="popup-body">
				<div class="contain card">
					<div class="head">
						<span class="fa fa-close fa-lg close"></span>
						<div class="icn" style="color: #79bbe7">
							<i class="fa fa-info-circle fa-lg"></i>
						</div>
						<h1>Apakah anda yakin?</h1><hr />
						<p>Anda akan membuka status blokir pengguna dengan nama <br /><span id="nama"></span></p>
					</div>
					<div class="input-group">
						<button id="confirmUnlock" class="btn green"><i class="fa fa-unlock fa-lg"></i>&nbsp;Buka</button> <button class="btn blue batal"><i class="fa fa-chevron-circle-left fa-lg"></i>&nbsp;Batal</button>
					</div>
				</div>
			</div>
		</div>


		<div class="overlay" id="edit-user-form">
			<div class="popup-body">
				<div class="contain card">
					<div class="head">
						<span class="fa fa-close fa-lg close"></span>
						<h1><i class="fa fa-pencil-square-o fa-lg"></i>&nbsp;Edit Profile</h1><hr />
						<div class="form">
							<form action="" method="post">
							<input type="hidden" name="idusers" id="iduser"/>
							<div class="input-group">
								<p>Username : </p>
								<input id="username" type="text" name="username" value="" class="input-text"/>
							</div>
							<div class="input-group">
								<p>Nama Lengkap : </p>
								<input id="nama_lengkap" type="text" name="nama_lengkap" value="" class="input-text" />
							</div>
							<div class="input-group">
								<p>Email : </p>
								<input id="email" type="email" name="email" value="" class="input-text" />
							</div>
							<div class="input-group">
								<p>Level : </p>
								<select name="level" id="level" class="input-text">
									<option value="general">General User</option>
									<option value="admin">Administrator</option>
								</select>
							</div>
							<div class="input-group">
								<p>Password : </p>
								<input type="text" name="password" class="input-text" />
							</div>
						</div>
					</div>
					<div class="input-group">
						<button type="submit" class="btn blue" name="btnSubmitEdit"><i class="fa fa-pencil-square fa-lg"></i>&nbsp;Save</button> <button type="button" class="btn red batal"><i class="fa fa-chevron-circle-left fa-lg"></i>&nbsp;Batal</button>
						</form>
					</div>
				</div>
			</div>
		</div>


		<script>
			function openEditUser(id,username,nama_lengkap,email,level) {
				$(".overlay#edit-user-form").fadeIn(100);
				$("#edit-user-form .popup-body").slideDown(300);
				$("#iduser").val(id);
				$("#username").val(username);
				$("#nama_lengkap").val(nama_lengkap);
				$("#email").val(email);
				$("#level").val(level);
			}

			$(document).ready(function(){
				// Inisialisasi datatable
				$("#daftarpengguna").DataTable();
				// fungsi2 native
				function act(id,act) {
					window.location.href = act+"?id=" + id;
				}
				function openDeleteConfirm(nama,id) {
					$(".overlay#deleteConfirm").fadeIn(100);
					$("#deleteConfirm .popup-body").slideDown(300);
					$("#deleteConfirm #nama").html(nama).fadeIn(700);
					$("#deleteConfirm #confirm").click(function(){
						act(id,"hapuspengguna");
					});
				}
				function openLockConfirm(nama,id) {
					$(".overlay#lockConfirm").fadeIn(100);
					$("#lockConfirm .popup-body").slideDown(300);
					$("#lockConfirm #nama").html(nama).fadeIn(700);
					$("#lockConfirm #confirmLock").click(function(){
						act(id,"lockpengguna");
					});
				}
				function openUnlockConfirm(nama,id) {
					$(".overlay#unlockConfirm").fadeIn(100);
					$("#unlockConfirm .popup-body").slideDown(300);
					$("#unlockConfirm #nama").html(nama).fadeIn(700);
					$("#unlockConfirm #confirmUnlock").click(function(){
						act(id,"unlockpengguna");
					});
				}
				function closePopup() {
					$(".overlay").fadeOut(100);
					$(".popup-body").slideUp(300);
				}


				// trigger element
				$(".hapus").on("click",function() {
					var nama = $(this).data("nama"),
						id = $(this).data("id");
					openDeleteConfirm(nama,id);
				});
				$(".lock").on("click",function() {
					var nama = $(this).data("nama"),
						id = $(this).data("id");
					openLockConfirm(nama,id);
				});
				$(".unlock").on("click",function() {
					var nama = $(this).data("nama"),
						id = $(this).data("id");
					openUnlockConfirm(nama,id);
				});


				$(".close").on("click",closePopup);
				$(".batal").on("click",closePopup);
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
