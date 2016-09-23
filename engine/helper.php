<?php

/* helper class */

class helper extends database {

	private $baseUrl = "http://localhost/tplt";

	public function getBaseUrl() {
		return $this->baseUrl;
	}

	public function tentukan_menu_aktif($parentActive,$expand = "none",$childActive = "none") {
		// Nilai default tiap menu adalah kosong
		$menu = array(
			/* ----- Parent Menu ----- */
			"home" => "",
			"infoweb" => "",
			"gallery" => "",
			"import" => "",
			"runningtext" => "",
			"gambarbanner" => "",
			"daftarpengguna" => "",
			"tambahpengguna" => "",
			/* ----- Expand Dropdown ----- */
			"beritaChild" => "",
			"galleryChild" => "",
			"agendaChild" => "",
			"temaChild" => "",
			/* ----- Childs ----- */
			"daftarberita" => "",
			"tambahberita" => "",
			"editberita" => "",
			"daftarfoto" => "",
			"tambahfoto" => "",
			"daftaragenda" => "",
			"tambahagenda" => "",
			"gantitema" => "",
			"edittema" => ""
		);
		// Ganti menu sesuai pilihan
		$menu[$parentActive] = "current";
		$menu[$expand] = "expand";
		$menu[$childActive] = "current";

		return $menu;
	}

	public function redirect($kondisi,$lokasiTrue,$lokasiFalse) {
		if($kondisi === true) {
			header("location: $lokasiTrue");
			exit();
		} else {
			header("location: $lokasiFalse");
			exit();
		}
	}

	private function sedang_login() {
		return (isset($_SESSION["username"])) ? true : false;
	}

	public function logged_in_protect() {
		if($this->sedang_login() === true) {
			header("location: home");
			exit();
		}
	}

	public function logged_out_protect() {
		if($this->sedang_login() === false) {
			header("location: index");
			exit();
		}
	}

	private function is_admin() {
		return ($_SESSION["level"] == "admin") ? true : false;
	}

	public function admin_area_protect() {
		if($this->is_admin() === false) {
			$this->set_flashdata("red","Anda tidak berhak mengakses modul itu!");
			header("location: home");
			exit();
		}
	}

	public function batas_kata($string,$limit) {
		$kata = explode(" ",$string);
		if(count($kata) < $limit) {
			return strip_tags(implode(" ",$kata));
		} else {
			return strip_tags(implode(" ",array_splice($kata,0,$limit))."...");
		}
	}

	public function format_waktu($time) {
		$tanggalSekarang = date("d-M-Y");
		$tanggal = date("d-M-Y",strtotime($time));
		if($tanggalSekarang == $tanggal) {
			return "Hari ini - ".date("H:i",strtotime($time));
		} else {
			return date("d-M-Y H:i",strtotime($time));
		}
	}

	public function format_waktu_agenda($time) {
		return date("d - M - Y H:i",strtotime($time));
	}

	public function set_flashdata($type,$pesanError) {
		$_SESSION["notifikasi"]["type"] = $type;
		$_SESSION["notifikasi"]["pesan"] = $pesanError;
	}

	public function get_notif() {
		if(isset($_SESSION["notifikasi"])) {
			if($_SESSION["notifikasi"]["type"] == "red") {
				$icon = "fa-close";
			} else {
				$icon = "fa-check-circle";
			}
			echo "
				<div class='alert ".$_SESSION['notifikasi']['type']."' id='alert'>
					<p><i class='fa $icon fa-lg'></i>&nbsp;".$_SESSION['notifikasi']['pesan']."</p>
				</div>
			";
			unset($_SESSION["notifikasi"]);
		}
	}

	public function get_top_notif() {
		if(isset($_SESSION["notifikasi"])) {
			if($_SESSION["notifikasi"]["type"] == "red") {
				$icon = "fa-close";
			} else {
				$icon = "fa-check-circle";
			}
			echo "
				<div class='top-alert ".$_SESSION['notifikasi']['type']."' id='alert'>
					<p>&nbsp;".$_SESSION['notifikasi']['pesan']."</p>
				</div>
			";
			unset($_SESSION["notifikasi"]);
		}
	}

	public function buatLog($log_title,$log_desc) {
		$query = $this->db->prepare("
			INSERT INTO log_report(log_title,log_desc)
			VALUES (:lt,:ld);
		");
		$query->bindParam(":lt",$log_title);
		$query->bindParam(":ld",$log_desc);

		if($query->execute()) {
			return ($query->rowCount() > 0) ? true : false;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

}
