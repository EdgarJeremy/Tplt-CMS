<?php


class pengunjung extends database {
  private $helper;

  public function __construct($hl) {
    parent::__construct();
    $this->helper = $hl;
  }

  public function trackPengunjung() {
    $ip = $_SERVER["REMOTE_ADDR"];
    $browser_details = $this->getBrowser();
    $browser_name = $browser_details["name"];
    if($browser_name != 'Unknown') {
      if($this->cekIp($ip)) {
        $query = $this->db->prepare("
          INSERT INTO pengunjung (ip,browser) VALUES (:ip,:br);
        ");

        $query->bindParam(":ip",$ip);
        $query->bindParam(":br",$browser_name);

        if($query->execute()) {
          return ($query->rowCount() > 0) ? true : false;
        } else {
          var_dump($query->errorInfo());
          exit();
        }
      }
    }
  }

  public function cekIp($ip) {
    $query = $this->db->prepare("SELECT * FROM pengunjung WHERE ip = :ip");
    $query->bindParam(":ip",$ip);
    if($query->execute()) {
      return ($query->rowCount() > 0) ? false : true;
    } else {
      var_dump($query->errorInfo());
      exit();
    }
  }

  public function hitungJumlah() {
    $query = $this->db->prepare("SELECT * FROM pengunjung GROUP BY ip");
    if($query->execute()) {
      return $query->rowCount();
    } else {
      var_dump($query->errorInfo());
      exit();
    }
  }

  public function hitungJumlahDalamBulan($bln) {
    $query = $this->db->prepare("SELECT * FROM pengunjung WHERE (MONTH(`waktu_kunjungan`) = :bln) GROUP BY ip");
    $query->bindParam(":bln",$bln);
    if($query->execute()) {
      return $query->rowCount();
    } else {
      var_dump($query->errorInfo());
      exit();
    }
  }

  private function getBrowser() {
      $u_agent = $_SERVER['HTTP_USER_AGENT'];
      $bname = 'Unknown';
      $platform = 'Unknown';
      $version= "";

      //First get the platform?
      if (preg_match('/linux/i', $u_agent)) {
          $platform = 'linux';
      }
      elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
          $platform = 'mac';
      }
      elseif (preg_match('/windows|win32/i', $u_agent)) {
          $platform = 'windows';
      }

      // Next get the name of the useragent yes seperately and for good reason
      if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
      {
          $bname = 'Internet Explorer';
          $ub = "MSIE";
      }
      elseif(preg_match('/Firefox/i',$u_agent))
      {
          $bname = 'Mozilla Firefox';
          $ub = "Firefox";
      }
      elseif(preg_match('/Chrome/i',$u_agent))
      {
          $bname = 'Google Chrome';
          $ub = "Chrome";
      }
      elseif(preg_match('/Safari/i',$u_agent))
      {
          $bname = 'Apple Safari';
          $ub = "Safari";
      }
      elseif(preg_match('/Opera/i',$u_agent))
      {
          $bname = 'Opera';
          $ub = "Opera";
      }
      elseif(preg_match('/Netscape/i',$u_agent))
      {
          $bname = 'Netscape';
          $ub = "Netscape";
      }

      // finally get the correct version number
      $known = array('Version', $ub, 'other');
      $pattern = '#(?<browser>' . join('|', $known) .
      ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
      if (!preg_match_all($pattern, $u_agent, $matches)) {
          // we have no matching number just continue
      }

      // see how many we have
      $i = count($matches['browser']);
      if ($i != 1) {
          //we will have two since we are not using 'other' argument yet
          //see if version is before or after the name
          if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
              $version= $matches['version'][0];
          }
          else {
              $version= $matches['version'][1];
          }
      }
      else {
          $version= $matches['version'][0];
      }

      // check if we have a number
      if ($version==null || $version=="") {$version="?";}

      return array(
          'userAgent' => $u_agent,
          'name'      => $bname,
          'version'   => $version,
          'platform'  => $platform,
          'pattern'    => $pattern
      );
  }


}
