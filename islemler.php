<?php
$db = new PDO("mysql::host=localhost;dbname=chatting;charset=utf8","root","");



class kayit{
	
	public $sonuc = array();
	
	function kontrol($db){
		
		$ad = $_POST['kulad'];
		$sifre = $_POST['sifre'];
		$sifre2 = $_POST['sifre2'];
		
		$ad = htmlspecialchars(strip_tags($ad));
		$sifre = htmlspecialchars(strip_tags($sifre));
		$sifre2 = htmlspecialchars(strip_tags($sifre2));
		
		
		
		
		if(empty($ad)):
		
			$this->sonuc["sonuc"] = "1";
		
		elseif($sifre != $sifre2):
		
			$this->sonuc["sonuc"] = "5";
		
		elseif(empty($sifre) || empty($sifre2)):
		
			$this->sonuc["sonuc"] =  "2";
		
		else :
		
		$bak = $db->prepare("select * from kisiler where kullaniciad=?");
		$bak->bindParam(1,$ad,PDO::PARAM_STR);
		$bak->execute();
		
			if($bak->rowCount() > 0):
		
				$this->sonuc["sonuc"] = "3";
		
			else:
			$this->sonuc["sonuc"] =  "4";
			self::ekle($ad,$sifre,$db);
		
			endif;
		
		endif;
		
		
	}
	
	function ekle($kullaniciad,$sifre,$db){
		$bos = "";
		$ekle = $db->prepare("insert into kisiler(kullaniciad,sifre,arkadaslarid) VALUES('$kullaniciad','$sifre','$bos')");
		$ekle->execute();
		
		$id = $db->lastInsertId();
		
		$ekle = $db->prepare("insert into istekler(kullaniciid,arkadasistekid,yenimesajid) VALUES('$id','$bos','$bos')");
		$ekle->execute();
		
		$ekle = $db->prepare("insert into mesajlar(kullaniciid,mesajkutuları,yazıyorkutuları) VALUES('$id','$bos','$bos')");
		$ekle->execute();
		
		setcookie("kullaniciad",$kullaniciad);
		
		
	}
	
}

class giris{
	
	public $veri = array();
	
	function kontrol($db){
		
		$kulad = $_POST['kulad'];
		$sifre = $_POST['sifre'];
		
		$kulad = htmlspecialchars(strip_tags($kulad));
		$sifre = htmlspecialchars(strip_tags($sifre));
		
			if(empty($kulad) || empty($sifre)):
		
				$this->veri["sonuc"] = '<div class="alert alert-danger">Lütfen boş bırakmayınız</div>';
		
			else:
		
			$sec = $db->prepare("select * from kisiler where kullaniciad='$kulad' and sifre='$sifre'");	
			$sec->execute();
		
				if($sec->rowCount() == 0):
				
				$this->veri["sonuc"] = '<div class="alert alert-danger">Böyle bir kullanıcı bulamadık.</div>';
		
				else :
		
				$this->veri["sonuc"] = 1;
				
				setcookie('kullaniciad',$kulad);
			
				header("Refresh:0");
		
				endif;
		
		
			endif;
		
		
	}

	
}


$islem = $_GET['islem'];

switch($islem):

case "kayit":

	$kayit = new kayit;
    $kayit->kontrol($db);

	$array = $kayit->sonuc;

	echo json_encode($array);

break;

case "giris":

	$giris = new giris;
	$giris->kontrol($db);

	$array = $giris->veri;

	echo json_encode($array);

break;

case "csil":

setcookie("kullaniciad","",time()-1);

break;


endswitch;



?>