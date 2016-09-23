<?php

class agenda extends database {

	public $idagenda;
	public $judul;
	public $tempat;
	public $tanggal;
	public $mulai;
	public $selesai;
	public $deskripsi;

	public function tambah($judul,$tempat,$tanggal,$mulai,$selesai,$deskripsi) {
		$query = $this->db->prepare("
			INSERT INTO agenda (judul,idusers,tempat,tanggal,mulai,selesai,deskripsi)
			VALUES (?,?,?,?,?,?,?);
		");
		$data = array($judul,$_SESSION["idusers"],$tempat,$tanggal,$mulai,$selesai,$deskripsi);
		if($query->execute($data)) {
			return ($query->rowCount() > 0) ? true : false;
		} else {
			$query->errorInfo();
			exit();
		}
	}

	public function ambil($limit = 0) {
		if($limit == 0) {
			$sql = "SELECT * FROM agenda ORDER BY tanggal DESC;";
		} else {
			$sql = "SELECT * FROM agenda ORDER BY tanggal DESC LIMIT $limit";
		}
		$query = $this->db->prepare($sql);
		if($query->execute()) {
			if($query->rowCount() > 0) {
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
		$query = $this->db->prepare("SELECT * FROM agenda");
		if($query->execute()) {
			return $query->rowCount();
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function hapus($id) {
		$query = $this->db->prepare("DELETE FROM agenda WHERE idagenda = :idagenda");
		$query->bindParam(":idagenda",$id);
		if($query->execute()) {
			if($query->rowCount() > 0) {
				return true;
			} else return false;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

}
