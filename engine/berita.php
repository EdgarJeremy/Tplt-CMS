<?php

class berita extends database {

	public $idberita;
	public $user;
	public $emailuser;
	public $judul;
	public $gambar;
	public $isi;
	public $waktu;
	private $helper;
	private $baseurl = "http://localhost/tplt/";
	private $lebarGambar = 540;
	private $panjangGambar = 250;

	public function __construct($hl) {
		parent::__construct();
		$this->helper = $hl;
	}

	public function tambah($judul,$gambar,$isi) {
		if($judul != "" && $gambar != "" && $isi != "") {
			$this->uploadGambar($gambar);
			$namaBaru = $this->appendTime($gambar);
			$query = $this->db->prepare("
				INSERT INTO berita (idusers,judul,gambar,isi)
				VALUES (:idusers,:judul,:gambar,:isi);
			");
			$query->bindParam(":idusers",$_SESSION["idusers"]);
			$query->bindParam(":judul",$judul);
			$query->bindParam(":gambar",json_encode($namaBaru));
			$query->bindParam(":isi",$isi);

			if($query->execute()) {
				if($query->rowCount() > 0) {
					return true;
				} else {
					return false;
				}
			} else {
				print_r($query->errorInfo());
				exit();
			}

		} else {
			echo "<script>
					alert('Semua field harus diisi!');
					window.location.href = 'tambahberita';
				</script>";
			header("location: tambahberita");
			exit();
		}
	}

	public function hitungJumlah() {
		$query = $this->db->prepare("SELECT * FROM berita");
		if($query->execute()) {
			return $query->rowCount();
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function ambil($limit = 0) {
		if($limit == 0) {
			$sql = "
				SELECT berita.idberita, berita.judul,berita.idusers,berita.gambar,berita.isi,berita.waktu, users.nama_lengkap
				FROM berita
				LEFT JOIN users
				ON berita.idusers = users.idusers
				ORDER BY waktu DESC;
			";
		} else {
			$sql = "
				SELECT berita.idberita, berita.judul,berita.idusers,berita.gambar,berita.isi,berita.waktu, users.nama_lengkap
				FROM berita
				LEFT JOIN users
				ON berita.idusers = users.idusers
				ORDER BY waktu DESC
				LIMIT $limit;
			";
		}
		$query = $this->db->prepare($sql);
		if($query->execute()) {
			if($query->rowCount() > 0) {
				$data = $query->fetchAll(PDO::FETCH_ASSOC);
			} else {
				$data = false;
			}
			return $data;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function ambilNama($id) {
		$query = $this->db->prepare("SELECT judul FROM berita WHERE idberita = :id");

		$query->bindParam(":id",$id);

		if($query->execute()) {
			if($query->rowCount() > 0) {
				$data = $query->fetch(PDO::FETCH_ASSOC);
				return $data["judul"];
			} else {
				return false;
			}
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function getNextId($id) {
		$query = $this->db->prepare("SELECT idberita FROM berita WHERE idberita > :id LIMIT 1");
		$query->bindParam(":id",$id);
		if($query->execute()) {
			if($query->rowCount() > 0) {
				$data = $query->fetch(PDO::FETCH_ASSOC);
				return $data["idberita"];
			} else {
				return false;
			}
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function getPrevId($id) {
		$query = $this->db->prepare("SELECT idberita FROM berita WHERE idberita < :id ORDER BY idberita DESC LIMIT 1");
		$query->bindParam(":id",$id);
		if($query->execute()) {
			if($query->rowCount() > 0) {
				$data = $query->fetch(PDO::FETCH_ASSOC);
				return $data["idberita"];
			} else {
				return false;
			}
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	private function makeThumbnails($name) {
	    $thumbnail_width = $this->lebarGambar;
	    $thumbnail_height = $this->panjangGambar;
	    $thumb_beforeword = "thumb";
	    $arr_image_details = getimagesize("../img/berita/".$name);
	    $original_width = $arr_image_details[0];
	    $original_height = $arr_image_details[1];
	    if ($original_width > $original_height) {
	        $new_width = $thumbnail_width;
	        $new_height = intval($original_height * $new_width / $original_width);
	    } else {
	        $new_height = $thumbnail_height;
	        $new_width = intval($original_width * $new_height / $original_height);
	    }
	    $dest_x = intval(($thumbnail_width - $new_width) / 2);
	    $dest_y = intval(($thumbnail_height - $new_height) / 2);
	    if ($arr_image_details[2] == 1) {
	        $imgt = "ImageGIF";
	        $imgcreatefrom = "ImageCreateFromGIF";
	    }
	    if ($arr_image_details[2] == 2) {
	        $imgt = "ImageJPEG";
	        $imgcreatefrom = "ImageCreateFromJPEG";
	    }
	    if ($arr_image_details[2] == 3) {
	        $imgt = "ImagePNG";
	        $imgcreatefrom = "ImageCreateFromPNG";
	    }
	    if ($imgt) {
	        $old_image = $imgcreatefrom("../img/berita/".$name);
	        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
	        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
	        $imgt($new_image, "../img/berita/thumbs/$thumb_beforeword" . '_' . $name);
	    }
	}

	public function uploadGambar($gambar) {
		$lokasi = "../img/berita/";
		if($this->cekTipeGambar($gambar)) {
			$namaBaru = $this->appendTime($gambar);
			for($i=0;$i<count($namaBaru);$i++) {
				$stat = copy($gambar["tmp_name"][$i],$lokasi.$namaBaru[$i]);
				$this->makeThumbnails($namaBaru[$i]);
			}
			return ($stat) ? true : false;
		} else {
			if(count($gambar["name"]) > 1) {
				$this->helper->set_flashdata("red","Salah satu format gambar tidak diizinkan!");
			} else {
				$this->helper->set_flashdata("red","Format gambar tidak diizinkan!");
			}
			header("location: tambahberita");
			exit();
		}
	}

	public function cekTipeGambar($gambar) {
		$tipeDiizinkan = array("jpg","bmp","png","jpeg","gif");
    $status = true;
		foreach($gambar["name"] as $name) {
			$type = end(explode(".",$name));
			if(!in_array($type,$tipeDiizinkan)) {
        $status = false;
				break;
			} else {
        continue;
      }
		}
    return $status;
	}

	public function hapusGambar($id) {
		$query = $this->db->prepare("SELECT gambar FROM berita WHERE idberita = :idberita");
		$query->bindParam(":idberita",$id);
		if($query->execute()) {
			if($query->rowCount() > 0) {
				$file = $query->fetch(PDO::FETCH_ASSOC);
				$picts = json_decode($file["gambar"]);
				foreach($picts as $gambar) {
					unlink("../img/berita/".$gambar);
					unlink("../img/berita/thumbs/thumb_".$gambar);
				}
				return true;
			} else {
				return false;
			}
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function appendTime($gambar) {
		$nama = array();
		for($i=0;$i<count($gambar["name"]);$i++) {
			$nama[$i] = sha1(time()."_".$gambar["name"][$i]).".".end(explode(".",$gambar["name"][$i]));
		}
		return $nama;
	}

	public function ambilBerdasarkanUser($userid) {
		$query = $this->db->prepare("
			SELECT * FROM berita
			WHERE berita.idusers = :idusers;
		");
		$query->bindParam(":idusers",$userid);
		if($query->execute()) {
			if($query->rowCount() > 0) {
				$data = $query->fetchAll(PDO::FETCH_ASSOC);
				return $data;
			} else {
				return false;
			}
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function ambilBerdasarkanId($id) {
		$query = $this->db->prepare("
			SELECT berita.idberita,berita.idusers,berita.judul,berita.isi,berita.gambar,berita.waktu, users.nama_lengkap, users.email
			FROM berita
			LEFT JOIN users
			ON berita.idusers = users.idusers
			WHERE berita.idberita = :idberita;
		");
		$query->bindParam(":idberita",$id);
		if($query->execute()) {
			if($query->rowCount() > 0) {
				$data = $query->fetch(PDO::FETCH_ASSOC);
				$this->idberita = $data["idberita"];
				$this->user = $data["nama_lengkap"];
				$this->emailuser = $data["email"];
				$this->judul = $data["judul"];
				$this->gambar = $data["gambar"];
				$this->isi = $data["isi"];
				$this->waktu = $data["waktu"];
				return $data;
			} else {
				return false;
			}
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function cekBerita($id) {
		$query = $this->db->prepare("SELECT * FROM berita WHERE idberita = :id");
		$query->bindParam(":id",$id);
		if($query->execute()) {
			return ($query->rowCount() > 0) ? true : false;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function update($id,$judul,$isi) {
		$query = $this->db->prepare("
			UPDATE berita SET
			judul = :judul,
			isi = :isi
			WHERE idberita = :idberita
			AND idusers = :idusers
		");
		$query->bindParam(":judul",$judul);
		$query->bindParam(":isi",$isi);
		$query->bindParam(":idberita",$id);
		$query->bindParam(":idusers",$_SESSION["idusers"]);

		if($query->execute()) {
			return ($query->rowCount() > 0) ? true : false;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function hapus($id) {
		if($this->hapusGambar($id)) {
			$query = $this->db->prepare("
				DELETE FROM berita WHERE idberita = :idberita;
			");
			$query->bindParam(":idberita",$id);
			if($query->execute()) {
				return ($query->rowCount() > 0) ? true : false;
			} else {
				var_dump($query->errorInfo());
				exit();
			}
		} else {
			return false;
		}
	}


}
