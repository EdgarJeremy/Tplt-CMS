<?php

class importer extends database {
	
	// Inisialisasi
	protected $init = "
		<?php
		require_once '../admin/engine/init.php';
		?>
	";
	// Objek ZipArchive
	protected $archiver;
	// Lokasi file
	protected $lokasiTemp = "../../public/";
	protected $lokasiFileIndex = "../../public/index.php";
	protected $lokasiDaftarBerita = "../../public/daftarberita.php";
	protected $lokasiDaftarGallery = "../../public/daftargallery.php";
	
	/* ------------------- Template kode program -------------------*/		
		
		// Berita
		protected $mulaiLoopBerita = "
				<?php
				\$data = \$berita->ambil();
				if(\$data != false):
				foreach(\$data as \$news):
				?>
		";
		protected $mulaiLoopGambarBerita = "
			<?php
			\$pictures = json_decode(\$news['gambar']);
			foreach(\$pictures as \$gambar):
			?>
		";
		protected $akhirLoop = "
			<?php endforeach;?>
		";
		protected $akhirLoopBerita = "
				<?php
				endforeach;endif;
				?>
		";
		// Agenda
		protected $mulaiLoopAgenda = "
			<?php
			\$data = \$agenda->ambil();
			if(\$data != false):
			foreach(\$data as $\agd):
			?>
		";
		protected $akhirLoopAgenda = "
			<?php
			endforeach;endif;
			?>
		";
		// Gallery
		protected $mulaiLoopGallery = "
			<?php
			\$data = \$gallery->ambil();
			if(\$data != false):
			foreach(\$data as \$gambar):
			?>
		";
		protected $akhirLoopGallery = "
			<?php
			endforeach;endif;
			?>
		";
	
	// Konfigurasi Berita
	protected $konfigBerita = "
		<?php
		if(!isset(\$_GET['id'])) {
			header('location: daftarberita.php');
			exit();
		}
		\$news = \$berita->ambilBerdasarkanId(\$_GET['id']);
		?>
	";
	
	/*------------------- Variabel data -------------------*/
		
		// Berita
		protected $idBerita = "
			<?php echo \$news['idberita'];?>
		";
		protected $judulBerita = "
			<?php echo \$news['judul'];?>
		";
		protected $waktuBerita = "
			<?php echo \$helper->format_waktu(\$news['waktu']);?>
		";
		protected $userBerita = "
			<?php \$news['username'];?>
		";
		protected $isiBerita = "
			<?php \$news['isi'];?>
		";
		protected $gambar = "
			<?php echo \$gambar;?>
		";
		// Agenda
		protected $idAgenda = "
			<?php echo \$agd['idagenda'];?>
		";
		protected $judulAgenda = "
			<?php echo \$agd['judul'];?>
		";
		protected $tanggalAgenda = "
			<?php echo \$agd['tanggal'];?>
		";
		protected $mulaiAgenda = "
			<?php echo \$agd['mulai'];?>
		";
		protected $tempatAgenda = "
			<?php echo \$agd['tempat'];?>
		";
		// Gallery
		protected $idGallery = "
			<?php echo \$gambar['idgallery'];?>
		";
		protected $namaGambar = "
			<?php echo \$gambar['nama_gambar'];?>
		";
		protected $deskripsiGambar = "
			<?php echo \$gambar['deskripsi'];?>
		";
		protected $waktuGambar = "
			<?php echo \$gambar['waktu'];?>
		";
		protected $userGambar = "
			<?php echo \$gambar['username'];?>
		";
	
	
	public function __construct($archiver) {
		$this->archiver = $archiver;
	}
	
	public function upload($zip) {
		
		$this->zip = $zip["name"];
		
		$cp = copy($zip["tmp_name"],$this->lokasiTemp.$this->zip);
		if($cp === true) {
			$zipHasilUpload = "../../public/".$this->zip;
			if($this->archiver->open($zipHasilUpload)){
				$extract = $this->archiver->extractTo($this->lokasiTemp);
				$this->parse();
				return ($extract) ? true : false;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}
	
	public function parse() {
		if(file_exists("../../public/header.php")) {
			$header = file_get_contents("../../public/header.php");
			$header = str_replace("<!-- init -->",$this->init,$header);
			file_put_contents("../../public/header.php",$header);
			$fileIndex = file_exists($this->lokasiFileIndex);
			if($fileIndex === true) {
				if(file_exists($this->lokasiDaftarBerita)) {
					$berita = file_get_contents($this->lokasiDaftarBerita);
					$berita = str_replace("<!-- mulailoopberita -->",$this->mulaiLoopBerita,$berita);
					$berita = str_replace("<!-- idberita -->",$this->idBerita,$berita);
					$berita = str_replace("<!-- judulberita -->",$this->judulBerita,$berita);
					$berita = str_replace("<!-- waktuberita -->",$this->waktuBerita,$berita);
					$berita = str_replace("<!-- userberita -->",$this->userBerita,$berita);
					$berita = str_replace("<!-- mulailoopgambarberita -->",$this->mulaiLoopGambarBerita,$berita);
					$berita = str_replace("<!-- gambar -->",$this->gambar,$berita);
					$berita = str_replace("<!-- akhirloop -->",$this->akhirLoop,$berita);
					$berita = str_replace("<!-- isiberita -->",$this->isiBerita,$berita);
					$berita = str_replace("<!-- akhirloopberita -->",$this->akhirLoopBerita,$berita);
					file_put_contents($this->lokasiDaftarBerita,$berita);
				}
			} else {
				echo "<script>
						alert('Tidak ada file index ditemukan! Mohon sediakan file index!');
						window.location.href = '../import';
					  </script>";
				$this->hapusTemp("../../public/*");
				exit();
			}
		} else {
				echo "<script>
						alert('Tidak ada file header ditemukan! Mohon sediakan file header!');
						window.location.href = '../import';
					  </script>";
				$this->hapusTemp("../../public/*");
				exit();
		}
		
	}
	
	public function hapusTemp($path) {
		$files = glob($path);
			foreach($files as $file){
			if(is_file($file))
				unlink($file);
			}
	}
	
}

?>