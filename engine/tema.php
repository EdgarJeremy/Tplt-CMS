<?php

class tema extends database {

	public $idtema;
	public $nama_tema;
	public $css;
	public $lokasi_file = "css/tema/";

	public function ambilTemaAktif($mode) {

		$status = "aktif";

		if($mode == "back") {
			$query = $this->db->prepare("SELECT * FROM tema_backend WHERE status = :status");
			$query->bindParam(":status",$status);
		} else {
			$query = $this->db->prepare("SELECT * FROM tema_frontend WHERE status = :status");
			$query->bindParam(":status",$status);
		}

		if($query->execute()) {
			if($query->rowCount() > 0) {
				$data = $query->fetch(PDO::FETCH_ASSOC);
				if($mode == "back") {
					$this->idtema = $data["idtema_backend"];
				} else {
					$this->idtema = $data["idtema_frontend"];
				}
				$this->nama_tema = $data["nama_tema"];
				$this->css = $data["css"];

				if($mode == "back") {
					$tempat = $this->lokasi_file.$this->css;
				} else {
					$tempat = "css/".$this->css;
				}

				echo
				"<link id='custTema' rel='stylesheet' href='".$tempat."' />";
			} else {
				return false;
			}
		} else {
			var_dump($query->errorInfo());
			exit();
		}



	}

	public function ambil($mode) {
		if($mode == "back") {
			$query = $this->db->prepare("SELECT * FROM tema_backend WHERE status = 'nonaktif' ORDER BY nama_tema ASC");
		} else {
			$query = $this->db->prepare("SELECT * FROM tema_frontend WHERE status = 'nonaktif' ORDER BY nama_tema ASC");
		}

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

	public function update($css,$mode) {
		if($mode == "back") {
			$query = $this->db->prepare("
				UPDATE tema_backend
				SET status = 'nonaktif'
				WHERE css != :css;
				UPDATE tema_backend
				SET status = 'aktif'
				WHERE css = :css;
			");
			$query->bindParam(":css",$css);
		} else {
			$query = $this->db->prepare("
				UPDATE tema_frontend
				SET status = 'nonaktif'
				WHERE css != :css;
				UPDATE tema_frontend
				SET status = 'aktif'
				WHERE css = :css;
			");
			$query->bindParam(":css",$css);
		}
		#$query->bindParam(":css",$css);
		if($query->execute()) {
			return true;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function ambilIsi($css) {
		$content = file_get_contents("../".$this->lokasi_file.$css);
		return $content;
	}


}
