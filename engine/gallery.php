<?php

class gallery extends database {

	public $nama_gambar;
	public $username;
	public $deskripsi;
	public $waktu;
	private $helper;
	private $lebarGambar = 330;
	private $panjangGambar = 195;

  public function __construct($hl) {
    parent::__construct();
    $this->helper = $hl;
  }

	public function ambil($limit = 0) {
		if($limit == 0) {
			$sql = "
				SELECT gallery.idgallery,gallery.nama_gambar,gallery.deskripsi,gallery.waktu, users.nama_lengkap
				FROM gallery
				LEFT JOIN users
				ON gallery.idusers = users.idusers
				ORDER BY waktu DESC;
			";
		} else {
			$sql = "
			SELECT gallery.idgallery,gallery.nama_gambar,gallery.deskripsi,gallery.waktu, users.nama_lengkap
			FROM gallery
			LEFT JOIN users
			ON gallery.idusers = users.idusers
			ORDER BY waktu DESC
			LIMIT $limit
			";
		}
		$query = $this->db->prepare($sql);
		if($query->execute()) {
			if($query->rowCount() > 1) {
				return $query->fetchAll(PDO::FETCH_ASSOC);
			} else {
				return false;
			}
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function hitungJumlah() {
		$query = $this->db->prepare("SELECT * FROM gallery");
		if($query->execute()) {
			return $query->rowCount();
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function tambah($gambar,$deskripsi) {
		if(is_array($gambar) && is_array($deskripsi)) {
			$namaBaru = $this->appendTime($gambar);
			$this->uploadGambar($gambar,$namaBaru);
			$rows = array();
			foreach($namaBaru as $key => $nama) {
				$rows[] = array($_SESSION["idusers"],$nama,$deskripsi[$key]);
			}
			$argumen = array_fill(0,count($rows[0]),"?");
			$sql = "INSERT INTO gallery (idusers,nama_gambar,deskripsi) VALUES (" . implode(",",$argumen) . ")";
			$query = $this->db->prepare($sql);

			foreach($rows as $row) {
				$query->execute($row);
			}
			return true;
		} else {
			echo "<script>
					alert('Semua field harus diisi!');
					window.location.href = 'tambahgallery';
				</script>";
			exit();
		}
	}

	private function makeThumbnails($name) {
	    $thumbnail_width = $this->lebarGambar;
	    $thumbnail_height = $this->panjangGambar;
	    $thumb_beforeword = "thumb";
	    $arr_image_details = getimagesize("../img/gallery/".$name);
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
	        $old_image = $imgcreatefrom("../img/gallery/".$name);
	        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
	        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
	        $imgt($new_image, "../img/gallery/thumbs/$thumb_beforeword" . '_' . $name);
	    }
	}

	public function uploadGambar($gambar,$namaBaru) {
		$lokasi = "../img/gallery/";
		if($this->cekTipeGambar($gambar)) {
			for($i=0;$i<count($namaBaru);$i++) {
				copy($gambar["tmp_name"][$i],$lokasi.$namaBaru[$i]);
				$this->makeThumbnails($namaBaru[$i]);
			}
		} else {
      if(count($gambar["name"]) > 1) {
  			$this->helper->set_flashdata("red","Salah satu format gambar tidak diizinkan!");
      } else {
        $this->helper->set_flashdata("red","Format gambar tidak diizinkan!");
      }
      $this->helper->buatLog("Upload foto dengan format tidak diizinkan","User dengan nama ".$_SESSION["nama_lengkap"]." mencoba mengupload foto dengan format yang tidak diizinkan");
			header("location: tambahfoto");
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

	public function appendTime($gambar) {
		$nama = array();
		for($i=0;$i<count($gambar["name"]);$i++) {
			$nama[$i] = sha1(time()."_".$gambar["name"][$i]).".".end(explode(".",$gambar["name"][$i]));
		}
		return $nama;
	}

	public function ambilBerdasarkanId($id) {
		$query = $this->db->prepare("SELECT * FROM gallery WHERE idgallery = :idgallery");
		$query->bindParam(":idgallery",$id);
		if($query->execute()) {
			if($query->rowCount() > 0) {
				$data =  $query->fetch(PDO::FETCH_ASSOC);
				$this->nama_gambar = $data["nama_gambar"];
				$this->deskripsi = $data["deskripsi"];
				$this->username = $data["username"];
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

	public function hapus($id) {
		$this->db->beginTransaction();
		if($this->ambilBerdasarkanId($id)) {
			$query = $this->db->prepare("
				DELETE FROM gallery WHERE idgallery = :idgallery;
			");
			$query->bindParam(":idgallery",$id);
			if($query->execute()) {
				$delete = unlink("../img/gallery/".$this->nama_gambar);
				unlink("../img/gallery/thumbs/thumb_".$this->nama_gambar);
				if($delete === true) {
					$this->db->commit();
					return true;
				} else {
					$this->db->rollBack();
					return false;
				}
			} else {
				var_dump($query->errorInfo());
				exit();
			}
		} else {
			return false;
		}

	}

}
