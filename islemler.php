<?php
$db = new PDO("mysql::host=localhost;dbname=chatting;charset=utf8","root","");

function veri_turn_array($veri){
	
	$array = explode('-',$veri);
	return $array;
}

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
		setcookie("kullaniciid",$id);
		
		
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
			$sonuc = $sec->fetch(PDO::FETCH_ASSOC);
		
				if($sec->rowCount() == 0):
				
				$this->veri["sonuc"] = '<div class="alert alert-danger">Böyle bir kullanıcı bulamadık.</div>';
		
				else :
		
				$this->veri["sonuc"] = 1;
					
				$id = $sonuc["id"];
				
				setcookie('kullaniciad',$kulad);
				setcookie("kullaniciid",$id);
			
				header("Refresh:0");
		
				endif;
		
		
			endif;
		
		
	}

	
}

class chat{
	
	public $dbkisiler = array();//"12"=>"Emirhan" id'si ve verisi key val şeklinde tutulur
	public $istekler = array("arkadas"=>array(),"mesaj"=>array());//id şeklinde veriler tutulur
	public $arkadasistekisimleri = array();//"0"=>"Emirhan","1"=>"Miray"....
	
	function bilgileri_al($db){
		//Burada bütün bilgileri sırasıyla veritabanından arraylere atıcaz.
		
		$sec = $db->prepare("select * from kisiler");
		$sec->execute();
		
			while($sonuc = $sec->fetch(PDO::FETCH_ASSOC)):
		
				$this->dbkisiler[$sonuc["id"]] = $sonuc["kullaniciad"];
		
			endwhile;
				
	}
	
	
	//İstekler javascript ile saniyede 1 çalışacak ve sonuçlar gitmesi gereken yere load edilecek
	
	function istekleri_al($db,$id){
				$sec = $db->prepare("select * from istekler where kullaniciid = $id ");
		$sec->execute();
		$sonuc = $sec->fetch(PDO::FETCH_ASSOC);
		
			$array = veri_turn_array($sonuc['arkadasistekid']);
				
			foreach($array as $val):
		
				if(!empty($val)):
				$this->istekler["arkadas"][] = $val;
				endif;
		
			endforeach;
		
			$array = veri_turn_array($sonuc['yenimesajid']);
			
			foreach($array as $val):
		
				if(!empty($val)):
				$this->istekler["mesaj"][]=$val;
				endif;
		
			endforeach;
		
	}
	
	function arkadas_istek_isimleri($db){
		
		foreach($this->istekler["arkadas"] as $val):
		
		$this->arkadasistekisimleri[] = $this->dbkisiler[$val];
		
		endforeach;
		
	}
	
	function istekler_dropdown($array){
		
		foreach($array as $val):
		
		echo ' <a class="dropdown-item" href="#">'.$val.' 
		<div style="display: inline-block; float:right;"><span class="btn btn-sm btn-primary">&#x2713;</span> <span class="btn btn-sm btn-danger">X</span>
		</div>
	  </a>';
		
		endforeach;
		
	}
	
}


@$islem = $_GET['islem'];

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

case "arkadasistekgetir":

$frqcount = count($islemler->istekler["arkadas"]);
echo $frqcount;

break;

case "dropdownlistegetir":

$islemler->arkadas_istek_isimleri($db);

$islemler->istekler_dropdown($islemler->arkadasistekisimleri);

break;

case "istekguncelle":

$islemler->istekleri_al($db,$id);

break;

endswitch;



?>