<?php
require_once "engine/init.php";
if(isset($_POST["btnSubmitUploadFoto"])) {
	$currFile = explode(".",end(explode("/",$_SERVER["PHP_SELF"])))[0];
	$cond = $pengguna->gantiFotoProfil($_FILES["foto"]);
	if($cond === true) {
		$helper->set_flashdata("green","Foto profil berhasil diubah");
		$helper->buatLog("Perubahan foto profil","User dengan nama ".$_SESSION["nama_lengkap"]." mengganti foto profil");
	} else {
		$helper->buatLog("Percobaan mengubah foto profil","User dengan nama ".$_SESSION["nama_lengkap"]." gagal mengubah foto profil");
	}
	header("location: ".$currFile);
	exit();
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $title;?></title>
		<link rel="stylesheet" href="css/font-awesome.min.css" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/main.css" />
		<link rel="stylesheet" href="css/jquery.dataTables.min.css" />
		<link rel="icon" href="img/tagconn.png" />
		<script src="js/jquery-3.0.0.min.js"></script>
		<script src="js/jquery.dataTables.js"></script>
		<link type="text/css" href="js/jqueryUI/jquery-ui.min.css" rel="Stylesheet" />
		<script type="text/javascript" src="js/jqueryUI/jquery-ui.min.js"></script>

		<!-- CodeMirror -->
		<script src="codemirror/lib/codemirror.js"></script>
		<link rel="stylesheet" href="codemirror/lib/codemirror.css">
		<script src="codemirror/mode/css/css.js"></script>
		<?php $tema->ambilTemaAktif("back");?>
	</head>
	<body>
		<div id="bijon">
		<header>
			<div class="logo">
				<h1><span class="fa fa-dashboard fa-lg"></span>&nbsp;Tplt BackEnd</h1>
			</div>
			<div class="access-ctrl">
				<ul class="menu-horizontal">
					<li><a href="home"><span class="fa fa-home fa-lg"></span>&nbsp;Beranda</a></li>
					<li>
						<a href="#" id="profile"><span class="fa fa-user fa-lg"></span>&nbsp;Profil (<?php echo $_SESSION["nama_lengkap"];?>)&nbsp;<span class="fa fa-caret-down fa-sm"></span></a>
						<ul class="drop-down">
							<li><a href="javascript:void(0)" id="edit-profile-btn">Edit Profil</a></li>
							<li><a href="#">Lihat Post Anda</a></li>
						</ul>
					</li>
					<li><a target="_blank" href="<?php echo $helper->getBaseUrl();?>"><span class="fa fa-globe fa-lg"></span>&nbsp;Ke Website</a></li>
					<li><a href="logout"><span class="fa fa-sign-out fa-lg"></span>&nbsp;Logout</a></li>
				</ul>
			</div>
		</header>
		<div class="sidebar">
				<div id="profile-wrap">
					<div class="col-md-5">
						<div class="photo-wrap">
							<form action="" method="post" enctype="multipart/form-data">
								<input type="file" name="foto" id="inputfile"/>
								<input type="submit" name="btnSubmitUploadFoto" id="goSubmit"/>
							</form>
							<span class="batch <?php echo ($_SESSION["level"] == "admin") ? "red" : "silver";?>"><i class="fa fa-<?php echo ($_SESSION["level"] == "admin") ? "key" : "user";?> fa-lg"></i>&nbsp;<?php echo $_SESSION["level"];?></span>
							<img src="img/fotoprofil/<?php echo $_SESSION["foto_profil"];?>" class="<?php echo ($_SESSION["level"] == "admin") ? "admin" : ""?>"/>
							<button id="uploadfoto"><i class="fa fa-upload fa-lg"></i></button>
						</div>
					</div>
					<div class="col-md-7">
						<h2><?php echo $_SESSION["nama_lengkap"];?></h2>
						<div class="pre">
							<?php
							$waktu = $pengguna->ambilWaktuLoginTerakhir();
							if($waktu != false):
							?>
							Login terakhir <br /><?php echo $helper->format_waktu($waktu);?>
							<?php else:?>
							Login Pertama
							<?php endif;?>
						</div>
						<span class="sum blue"><i class="fa fa-picture-o fa-lg"></i>&nbsp;<?php echo $pengguna->jumlahFoto;?></span>
						<span class="sum red"><i class="fa fa-newspaper-o fa-lg"></i>&nbsp;<?php echo $pengguna->jumlahBerita;?></span>
						<span class="sum green"><i class="fa fa-book fa-lg"></i>&nbsp;<?php echo $pengguna->jumlahAgenda;?></span>
					</div>
				</div>
				<div id="list-menu-wrap">
					<div class="group-menu">
					<div class="name-part modul">
						<h2>&nbsp;Modul</h2>
					</div>
					<div class="list-content">
						<ul class="list-menu">
							<li class="<?php echo $menu["home"];?>"><a href="home"><span class="fa fa-home fa-lg"></span>&nbsp;Home</a></li>
							<?php if($_SESSION["level"] == "admin"):?>
							<li class="<?php echo $menu["infoweb"];?>"><a href="infoweb"><span class="fa fa-globe fa-lg"></span>&nbsp;Info Web</a></li>
							<?php endif;?>
							<li>
								<a href="#" id="keberita"><span class="fa fa-newspaper-o fa-lg"></span>&nbsp;Berita&nbsp;<span class="fa fa-angle-double-right fa-lg" style="float: right"></span></a>
								<ul class="list-menu level-two <?php echo $menu["beritaChild"];?>" id="berita">
									<li class="<?php echo $menu["daftarberita"];?>"><a href="daftarberita"><span class="fa fa-angle-right fa-sm"></span>&nbsp;Daftar Berita</a></li>
									<li class="<?php echo $menu["tambahberita"];?>"><a href="tambahberita"><span class="fa fa-angle-right fa-sm"></span>&nbsp;Tambah Berita</a></li>
									<li class="<?php echo $menu["editberita"];?>"><a href="editberita"><span class="fa fa-angle-right fa-sm"></span>&nbsp;Edit Berita</a></li>
								</ul>
							</li>
							<li class="<?php echo $menu["gallery"];?>">
								<a href="#" id="kegallery"><span class="fa fa-picture-o fa-lg"></span>&nbsp;Gallery&nbsp;<span class="fa fa-angle-double-right fa-lg" style="float: right"></span></a>
								<ul class="list-menu level-two <?php echo $menu["galleryChild"];?>" id="gallery">
									<li class="<?php echo $menu["daftarfoto"];?>"><a href="daftarfoto"><span class="fa fa-angle-right fa-sm"></span>&nbsp;Daftar Foto</a></li>
									<li class="<?php echo $menu["tambahfoto"];?>"><a href="tambahfoto"><span class="fa fa-angle-right fa-sm"></span>&nbsp;Tambah Foto</a></li>
								</ul>
							</li>
							<li>
								<a href="#" id="keagenda"><span class="fa fa-book fa-lg"></span>&nbsp;Agenda&nbsp;<span class="fa fa-angle-double-right fa-lg" style="float: right"></span></a>
								<ul class="list-menu level-two <?php echo $menu["agendaChild"];?>" id="agenda">
									<li class="<?php echo $menu["daftaragenda"];?>"><a href="daftaragenda"><span class="fa fa-angle-right fa-sm"></span>&nbsp;Daftar Agenda</a></li>
									<li class="<?php echo $menu["tambahagenda"];?>"><a href="tambahagenda"><span class="fa fa-angle-right fa-sm"></span>&nbsp;Tambah Agenda</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<div class="group-menu">
					<div class="name-part layout">
						<h2>&nbsp;Layout</h2>
					</div>
					<div class="list-content">
						<ul class="list-menu">
							<?php if($_SESSION["level"] == "admin"):?>
							<li class="<?php echo $menu["import"];?>"><a href="import"><span class="fa fa-object-group fa-lg"></span>&nbsp;Import Layout</a></li>
							<li>
								<a href="#" id="ketema"><span class="fa fa-paint-brush fa-lg"></span>&nbsp;Tema&nbsp;<span class="fa fa-angle-double-right fa-lg" style="float: right"></span></a>
								<ul class="list-menu level-two <?php echo $menu["temaChild"];?>" id="tema">
									<li class="<?php echo $menu["gantitemaback"];?>"><a href="gantitemaback"><span class="fa fa-angle-right fa-sm"></span>&nbsp;Ganti Tema (BackEnd)</a></li>
									<li class="<?php echo $menu["gantitemafront"];?>"><a href="gantitemafront"><span class="fa fa-angle-right fa-sm"></span>&nbsp;Ganti Tema (FrontEnd)</a></li>
									<li class="<?php echo $menu["edittema"];?>"><a href="edittema"><span class="fa fa-angle-right fa-sm"></span>&nbsp;Edit Tema</a></li>
								</ul>
							</li>
							<?php endif;?>
							<li class="<?php echo $menu["runningtext"];?>"><a href="runningtext"><span class="fa fa-align-left fa-lg"></span>&nbsp;Running Text</a></li>
							<li class="<?php echo $menu["gambarbanner"];?>"><a href="#" id=""><span class="fa fa-camera fa-lg"></span>&nbsp;Gambar Banner&nbsp;</span></a></li>
						</ul>
					</div>
				</div>
				<?php if($_SESSION["level"] == "admin"):?>
				<div class="group-menu">
					<div class="name-part pengguna">
						<h2>&nbsp;Pengguna</h2>
					</div>
					<div class="list-content">
						<ul class="list-menu">
							<li class="<?php echo $menu["daftarpengguna"];?>"><a href="daftarpengguna"><span class="fa fa-list fa-lg"></span>&nbsp;Daftar Pengguna</a></li>
							<li class="<?php echo $menu["tambahpengguna"];?>"><a href="tambahpengguna"><span class="fa fa-user-plus fa-lg"></span>&nbsp;Tambah Pengguna</a></li>
						</ul>
					</div>
				</div>
				<?php endif;?>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				// // Scroll sidebar
				// var parent = $(".sidebar"),
				// 		target = $(".home");
				// parent.scrollTop(parent.scrollTop() + )

				$("#uploadfoto").on("click",function(){
					$("#inputfile").trigger("click");
				});
				$("#inputfile").on("change",function(){
					var namaFile = $(this).val(),
							part = namaFile.split("\\"),
							file = part[part.length - 1].split("."),
							tipe = file[file.length - 1];
					var tipeDiizinkan = ["png","bmp","gif","jpg","jpeg"];
					if(tipe != tipeDiizinkan[0] && tipe != tipeDiizinkan[1] && tipe != tipeDiizinkan[2] && tipe != tipeDiizinkan[3] && tipe != tipeDiizinkan[4]) {
						alert("Tipe gambar tidak valid! Mohon pilih gambar dengan format png/bmp/gif/jpg/jpeg");
					} else {
						$("#goSubmit").trigger("click");
					}
				});
			});
		</script>
