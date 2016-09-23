<?php

class infoweb extends database {

	public $runningtext;
	public $banner;
	public $nama_web;
	public $deskripsi_web;

	public function editRunningText($postData) {

		$json = json_encode($postData);

		$query = $this->db->prepare("
			UPDATE info_web
			SET running_text = ?
			WHERE idinfo_web = 1;
		");

		if($query->execute(array($json))) {
			return ($query->rowCount() > 0) ? true : false;
		} else {
			var_dump($query->errorInfo());
			exit();
		}

	}

	public function ambilNamaWeb() {
		$query = $this->db->prepare("SELECT nama_web FROM info_web WHERE idinfo_web = 1");

		if ($query->execute()) {
			$data = $query->fetch(PDO::FETCH_ASSOC);
			return $data["nama_web"];
		} else {
			var_dump($query->errorInfo());
			exit();
		}

	}

	public function ambilDeskripsiWeb() {
		$query = $this->db->prepare("SELECT deskripsi_web FROM info_web WHERE idinfo_web = 1");

		if($query->execute()) {
			$data = $query->fetch(PDO::FETCH_ASSOC);
			return $data["deskripsi_web"];
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

	public function ambilRunningText() {

		$query = $this->db->prepare("
			SELECT running_text FROM info_web
		");
		if($query->execute()) {
			if($query->rowCount() > 0) {
				$data = $query->fetch(PDO::FETCH_ASSOC);
				return json_decode($data["running_text"]);
			} else {
				return false;
			}
		} else {
			var_dump($query->errorInfo());
			exit();
		}

	}

	public function setInfoWeb($namaweb,$deskripsi) {
		$query = $this->db->prepare("UPDATE info_web SET nama_web = :nm, deskripsi_web = :ds WHERE idinfo_web = 1");
		$query->bindParam(":nm",$namaweb);
		$query->bindParam(":ds",$deskripsi);
		if($query->execute()) {
			return ($query->rowCount() > 0) ? true : false;
		} else {
			var_dump($query->errorInfo());
			exit();
		}
	}

}
