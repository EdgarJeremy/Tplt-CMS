<?php

class pengguna extends database {
	public $jumlahBerita;
	public $jumlahFoto;
	public $jumlahAgenda;
	private $helper;

	public function __construct($hl) {
		parent::__construct();
		$this->helper = $hl;
		$this->jumlahBerita = $this->ambilJumlah("berita");
		$this->jumlahFoto = $this->ambilJumlah("gallery");
		$this->jumlahAgenda = $this->ambilJumlah("agenda");
	}

	public function login($username,$password) {
		$query = $this->db->prepare("
			SELECT * FROM users
			WHERE username = :username AND
			password = :password AND blokir = 'N';
		");
		$query->bindParam(":username",$username);
		$query->bindParam(":password",md5($password));
		if($query->execute()){
			$data = $query->fetch(PDO::FETCH_ASSOC);
			if(count($data) > 0 && $data !== false) {
				$_SESSION["username"] = $data["username"];
				$_SESSION["level"] = $data["level"];
				$_SESSION["idusers"] = $data["idusers"];
				$_SESSION["email"] = $data["email"];
				$_SESSION["nama_lengkap"] = $data["nama_lengkap"];
				$_SESSION["foto_profil"] = $data["foto_profil"];
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}

	}

	public function gantiFotoProfil($foto) {
		$this->db->beginTransaction();
		$extensi = end(explode(".",$foto["name"]));
		$tipeDiizinkan = array("png","jpg","jpeg","bmp","gif");
		if(in_array($extensi,$tipeDiizinkan)) {
			$namaBaru = $this->uploadFoto($foto);
			if($namaBaru != false) {
				$query = $this->db->prepare("UPDATE users SET foto_profil = :ft WHERE idusers = :id");
				$query->bindParam(":ft",$namaBaru);
				$query->bindParam(":id",$_SESSION["idusers"]);

				if($query->execute()) {
						unlink("img/fotoprofil/".$_SESSION["foto_profil"]);
						$this->db->commit();
						$_SESSION["foto_profil"] = $namaBaru;
						return ($query->rowCount() > 0) ? true : false;
				} else {
					var_dump($query->errorInfo());
					exit();
				}
			} else {
				return false;
			}
		} else {
			$this->helper->set_flashdata("red","Ba nakal kang? :v ");
			return false;
		}
	}

	public function uploadFoto($foto) {
		$lokasi = "img/fotoprofil/";
		$namaBaru = $this->generateName($foto);
		$cond = copy($foto["tmp_name"],$lokasi.$namaBaru);
		if($cond == true) {
			return $namaBaru;
		} else {
			return false;
		}
	}
	public function generateName($foto) {
		$namaBaru = sha1(time()."_".$foto["name"]).".".end(explode(".",$foto["name"]));
		return $namaBaru;
	}

	public function tambah($nama_lengkap,$username,$password,$email,$level) {
		$blokir = "N";
		$query = $this->db->prepare("
			INSERT INTO users (nama_lengkap,username,password,email,blokir,level)
			VALUES (?,?,?,?,?,?);
		");
		$dataInsert = array($nama_lengkap,$username,md5($password),$email,$blokir,$level);

		if($query->execute($dataInsert)) {
			return ($query->rowCount() > 0) ? true : false;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function ambil() {
		$query = $this->db->prepare("
			SELECT * FROM users WHERE idusers != ? ORDER BY nama_lengkap ASC;
		");
		if($query->execute(array($_SESSION["idusers"]))) {
			$data = $query->fetchAll(PDO::FETCH_ASSOC);
			return $data;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function hapus($id) {
		$query = $this->db->prepare("DELETE FROM users WHERE idusers = ?");
		if($query->execute(array($id))) {
			return ($query->rowCount() > 0) ? true : false;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function lock($id) {
		$query = $this->db->prepare("
			UPDATE users SET blokir = 'Y'
			WHERE idusers = ?
		");
		if($query->execute(array($id))) {
			return ($query->rowCount() > 0) ? true : false;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function unlock($id) {
		$query = $this->db->prepare("
			UPDATE users SET blokir = 'N'
			WHERE idusers = ?
		");
		if($query->execute(array($id))) {
			return ($query->rowCount() > 0) ? true : false;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function updateDataUser($id,$username,$nama_lengkap,$email,$password) {
		if($password == "") {
			$query = $this->db->prepare("
				UPDATE users SET
				username = :un,
				nama_lengkap = :nl,
				email = :em
				WHERE idusers = :id;
			");
			$query->bindParam(":un",$username);
			$query->bindParam(":nl",$nama_lengkap);
			$query->bindParam(":em",$email);
			$query->bindParam(":id",$id);

			if($query->execute()) {
				return ($query->rowCount() > 0) ? true : false;
			} else {
				var_dump($query->errorInfo());
				exit();
			}
		} else {
			$query = $this->db->prepare("
				UPDATE users SET
				username = :un,
				nama_lengkap = :nl,
				email = :em,
				password = :ps
				WHERE idusers = :id;
			");
			$query->bindParam(":un",$username);
			$query->bindParam(":nl",$nama_lengkap);
			$query->bindParam(":em",$email);
			$query->bindParam(":ps",md5($password));
			$query->bindParam(":id",$id);

			if($query->execute()) {
				return ($query->rowCount() > 0) ? true : false;
			} else {
				var_dump($query->errorInfo());
				exit();
			}
		}
	}

	public function updateDataUserLain($id,$username,$nama_lengkap,$email,$password,$level) {
		if($password == "") {
			$query = $this->db->prepare("
				UPDATE users SET
				username = :un,
				nama_lengkap = :nl,
				email = :em,
				level = :lv
				WHERE idusers = :id;
			");
			$query->bindParam(":un",$username);
			$query->bindParam(":nl",$nama_lengkap);
			$query->bindParam(":em",$email);
			$query->bindParam(":id",$id);
			$query->bindParam(":lv",$level);


			if($query->execute()) {
				return ($query->rowCount() > 0) ? true : false;
			} else {
				var_dump($query->errorInfo());
				exit();
			}
		} else {
			$query = $this->db->prepare("
				UPDATE users SET
				username = :un,
				nama_lengkap = :nl,
				email = :em,
				level = :lv,
				password = :ps
				WHERE idusers = :id;
			");
			$query->bindParam(":un",$username);
			$query->bindParam(":nl",$nama_lengkap);
			$query->bindParam(":em",$email);
			$query->bindParam(":ps",md5($password));
			$query->bindParam(":id",$id);
			$query->bindParam(":lv",$level);

			if($query->execute()) {
				return ($query->rowCount() > 0) ? true : false;
			} else {
				var_dump($query->errorInfo());
				exit();
			}
		}
	}

	public function ambilNama($id) {
		$query = $this->db->prepare("SELECT nama_lengkap FROM users WHERE idusers = :id");
		$query->bindParam(":id",$id);

		if($query->execute()) {
			if($query->rowCount() > 0) {
				$data = $query->fetch(PDO::FETCH_ASSOC);
				return $data["nama_lengkap"];
			} else {
				return false;
			}
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function ambilWaktuLoginTerakhir() {
		$query = $this->db->prepare("SELECT * FROM log_report WHERE log_title = 'User Login' AND log_desc LIKE '%".$_SESSION["nama_lengkap"]."%' ORDER BY log_time DESC LIMIT 1,1");
		if($query->execute()) {
			if($query->rowCount() > 0) {
				$data = $query->fetch(PDO::FETCH_ASSOC);
				return $data["log_time"];
			} else {
				return false;
			}
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function ambilJumlah($entitas) {
		$query = $this->db->prepare("SELECT COUNT(*) AS jumlah FROM $entitas  WHERE idusers = :id");
		$query->bindParam(":id",$_SESSION["idusers"]);
		if($query->execute()) {
			$data = $query->fetch(PDO::FETCH_ASSOC);
			return $data["jumlah"];
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}


}
