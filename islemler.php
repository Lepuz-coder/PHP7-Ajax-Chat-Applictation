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
	public $arkadasidler = array();//Giriş yapan kullanıcının arkadaşlarının id verilerini tutan bir arraydır
	
	//dbkisiler arkadasidler
	function bilgileri_al($db){
		//Burada bütün bilgileri sırasıyla veritabanından arraylere atıcaz.
		
		$sec = $db->prepare("select * from kisiler");
		$sec->execute();
		
			while($sonuc = $sec->fetch(PDO::FETCH_ASSOC)):
		
				$this->dbkisiler[$sonuc["id"]] = $sonuc["kullaniciad"];
				
				if($sonuc["id"] == $_COOKIE['kullaniciid']):
				
					if(!empty($sonuc["arkadaslarid"])):
				$this->arkadasidler = veri_turn_array($sonuc["arkadaslarid"]);
					endif;
				endif;
		
			endwhile;

		
		
	}
	
	//istekler
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
	
	//arkadasistekisimleri
	function arkadas_istek_isimleri($db){
		
		foreach($this->istekler["arkadas"] as $val):
		
		$this->arkadasistekisimleri[] = $this->dbkisiler[$val];
		
		endforeach;
		
	}
	
	function istekler_dropdown($array){
		$sonuc = "";
		$i = 1;
		foreach($array as $val):
		
		$sonuc .= '			
							<tr>
							  <th scope="row" class="isteksatir"></th>
							  <td>'.$val.'</td>
							  <td><button class="btn btn-success btn-sm kabulet" sectıonId="'.$val.'">&#x2713;</button></td>
							  <td><button class="btn btn-danger btn-sm reddet" sectıonId="'.$val.'">X</button></td>
							</tr>';
		$i++;
		endforeach;
		
		if(empty($sonuc)):
		$sonuc .='<tr>
							  <td colspan="3" class="alert alert-info text-center mt-3">Şu anlık istek bulunmamaktadır</td>
							</tr>';
		endif;
		
		$sonuc .= "<script>
				$(document).ready(function(){
		$('.kabulet').click(function(){
		 var deger = $(this).attr('sectıonId');
		 var iskelet = $(this).parent().parent();
		 $.post('islemler.php?islem=arkadasistekkabul',{'isim':deger},function(d){
				iskelet.hide();
				
			});
			});
			
		
				
			$('.reddet').click(function(){
		 var deger = $(this).attr('sectıonId');
		 var iskelet = $(this).parent().parent();
		 $.post('islemler.php?islem=arkadasistekreddet',{'isim':deger},function(d){
				iskelet.hide();				
			});
			  });
				});
			</script>";
		
		return $sonuc;
	}
	
	function istek_kabul($db){
		
		//Kabul edilen istek sonununda posttan alınan verinin isminden id'sini bularak buna göre istekler kısmını ve kullanıcnın arkadaşlar kısmını güncelle
		self::bilgileri_al($db);
		self::istekleri_al($db,$_COOKIE['kullaniciid']);
		$isim = $_POST['isim'];
		
		$id = array_search($isim,$this->dbkisiler);
		
		$fark = array($id);
		
		$array = array_diff($this->istekler["arkadas"],$fark);
		
		$dizin = implode("-",$array);
		
		$kulad = $_COOKIE['kullaniciid'];
		$upd = $db->prepare("update istekler set arkadasistekid='$dizin' where id=$kulad");
		$upd->execute();

		$this->arkadasidler[] = $id;
				
		$dizin = implode("-",$this->arkadasidler);
		
		$upd = $db->prepare("update kisiler set arkadaslarid='$dizin' where id=$kulad");
		$upd->execute();
		
		//Kabul Edilen Kişinin Arkadaşlarına Eklemesi :
		
		
		
		
	}
	
	function istek_reddet($db){
		self::bilgileri_al($db);
		self::istekleri_al($db,$_COOKIE['kullaniciid']);
		$isim = $_POST['isim'];
		
		$id = array_search($isim,$this->dbkisiler);
		
		$fark = array($id);
		
		$array = array_diff($this->istekler["arkadas"],$fark);
		
		$dizin = implode("-",$array);
		
		$kulad = $_COOKIE['kullaniciid'];
		$upd = $db->prepare("update istekler set arkadasistekid='$dizin' where id=$kulad");
		$upd->execute();
	}
	
	//!!İstek gönderdiğine tekrar gönderebiliyorsun ve istek ekstar olarak eklenmiyor sadece eskisinin yerine geçiyor düzelt!!
	function istek_gonder($db){
		self::bilgileri_al($db);
		self::arkadas_istek_isimleri($db);
		self::istekleri_al($db,$_COOKIE['kullaniciid']);
		
		$istek = $_POST['istekisim'];
		
		$istekid = array_search($istek,$this->dbkisiler);
		
		if(!in_array($istek,$this->dbkisiler)):
		
		echo '<div class="alert alert-danger">Böyle bir üye yok!</div>';
		
		elseif(in_array($istekid,$this->istekler["arkadas"])):
		
		echo '<div class="alert alert-warning">Zaten size arkadaşlık isteği göndermiş</div>';
		
		elseif(in_array($istekid,$this->arkadasidler)):
		
		echo '<div class="alert alert-warning">Zaten Arkadaşınız!</div>';
		
		elseif($istekid == $_COOKIE['kullaniciid']):
		
		echo '<div class="alert alert-danger">Kendinizle arkadaş değil misiniz :\'(</div>';
		
		else:
		
		
		$sec = $db->prepare("select * from istekler where kullaniciid = $istekid");
		$sec->execute();
		$sonuc = $sec->fetch(PDO::FETCH_ASSOC);
		$istekidistekleri = $sonuc['arkadasistekid'];//2-6-8
		
		if(!empty($istekidistekleri)):
		
		$array = explode("-",$istekidistekleri);
		
		else:
		
		$array = array();
		
		endif;
		
		if(in_array($_COOKIE['kullaniciid'],$array)):
		
		echo '<div class="alert alert-info">Zaten istek gönderilmiş</div>';
		
		else:
		
		$array[] = $_COOKIE['kullaniciid'];
		
		$dizin = implode("-",$array);
		
		$upd = $db->prepare("update istekler set arkadasistekid='$dizin' where kullaniciid=$istekid");
		$upd->execute();
		
		echo '<div class="alert alert-success">İstek Gönderilmiştir!</div>';
		
		
		endif;
		
		
		
		endif;
		
	}
	
	function db_ara($db){
		self::bilgileri_al($db);
		
		$aranan = $_POST['deger'];
		array_unshift($this->dbkisiler,"");
		$this->dbkisiler[]="";
		$veri = implode("-",$this->dbkisiler);//Emirhan Berkay Miray
		
		
		
		$pattern = '@-'.$aranan.'(.*?)-@si';
		
		preg_match_all($pattern,$veri,$sonuc);
		
		if(!empty($aranan)):
		
		foreach($sonuc[0] as $val):
			
				$val = str_replace("-","",$val);
			$isim = $this->dbkisiler[$_COOKIE['kullaniciid']];
			if($val !=$isim):
			echo '
			<script>
			$(document).ready(function(){
				$(\'input[name="sonucveri"]\').click(function(){
				$(\'input[name="istekisim"]\').val($(this).val());
				})
			})
			</script>
			<input type="button" class="btn btn-light btn-block" name="sonucveri" value="'.$val.'"></input>';
			endif;
		endforeach;
		endif;
		
		
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

case "dongu":
	
	$sonuc = array();

	$id = $_COOKIE['kullaniciid'];
	$islemler = new chat;
	$islemler->bilgileri_al($db);
	$islemler->istekleri_al($db,$id);

	$frqcount = count($islemler->istekler["arkadas"]);
	
	$sonuc["sayi"] = $frqcount;

	$islemler->arkadas_istek_isimleri($db);
	
	$sonuc["dropdown"] = $islemler->istekler_dropdown($islemler->arkadasistekisimleri);	
	
	$arkadaslar = "";
	$i=1;
	foreach($islemler->arkadasidler as $val):

	$isim = $islemler->dbkisiler[$val];

	$arkadaslar .= '<tr>
							  <td colspan="2"><a href="" class="text-danger">X </a>'.$isim.'</td>
							  <td><span class="text-secondary">Yeni mesaj</span></td>
							  <td><button class="btn btn-primary btn-sm" sectıonId="'.$val.'">Mesaj</button></td>
							</tr>';
	$i++;
	endforeach;
	
	$sonuc["arkadaslar"] = $arkadaslar;

	echo json_encode($sonuc);



break;

case "arkadasistekkabul":

$islem = new chat;
$islem->istek_kabul($db);

break;

case "arkadasistekreddet":

$islem = new chat;
$islem->istek_reddet($db);


case "istekgonder":

$islem = new chat;
$islem->istek_gonder($db);

break;

case "dbkullaniciara":

$islem = new chat;
$islem->db_ara($db);

break;


endswitch;



?>