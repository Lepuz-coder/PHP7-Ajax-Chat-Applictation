<?php
include("islemler.php");
	if(!isset($_COOKIE['kullaniciad'])):

		header("Location:giris.php");

	endif;
	$id = $_COOKIE['kullaniciid'];

	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Başlıksız Belge</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="chat.js"></script>
	
	<script type="text/javascript">
		
		$(document).ready(function(){
			$.post("islemler.php?islem=istekayarlarısayı",{},function(donen_veri){
				
				var veri = $.parseJSON(donen_veri);
				$('#dropdownistek').html(veri.dropdown);
				$('#frqcount').html(veri.sayi);
			});
			
			setInterval(function(){
				$.post("islemler.php?islem=istekayarlarısayı",{},function(donen_veri){
				
				var veri = $.parseJSON(donen_veri);
				$('#dropdownistek').html(veri.dropdown);
				$('#frqcount').html(veri.sayi);
			});
			},2000)
			
			$('#isteklertablosu').hide();
			$('#isteklerigorbuton').click(function(){
				$('#isteklertablosu').slideToggle(700);
			})
		})
		
		
	
	</script>

</head>

<body class="bg-light">
	
	
	<div class="container">
	
	<div class="row col-8 mx-auto border" style="margin-top: 50px; border-radius:3px; background-color:white;">
		
		<div class="container-fluid">
			
			<div class="row" style="height: 500px;">
			
				<div class="col-5 border-right border-light">
				
					<div class="row border-bottom border-light" >
						<div class="alert alert-info w-100 text-center mt-4 mr-4"><?php echo $_COOKIE['kullaniciad']; ?> <button class="btn btn-danger btn-sm btn-block mt-2" id="cik">ÇIK</button> </div>
					<img src="human-icon-png-13.jpg.png" width="50px;" >
						<span style="display: inline-block; margin:auto;"><span class="text-info" id="frqcount"></span> Arkadaşlık İsteği
						
							<!--İsteklerin Görüldüğü Yer-->
							<div class="mr-3" style="display: inline-block;">
  <div class="btn btn-primary ml-2" id="isteklerigorbuton">
    İstekleri Gör
  </div>
	
</div>
		
							
						
						
					</div>
						<!--Bu Bölümde Arkadaş İstekleri Görülür-->
						<div>
						<div class="row mx-auto" id="isteklertablosu" style="position: absolute; z-index: 1000; background-color: white; width: 90%; " >
						<div style="width: 100%; height: 70px; overflow-y:hidden;">
						<table class="table pt-5">
						  <thead>
							<tr>
							  <th colspan="4"></th>
							</tr>
						  </thead>
						  <tbody id="dropdownistek">
							
							
							  
						  </tbody>
						</table>
						</div>
					</div>
						</div>
						
					<div class="row mx-auto bg-white" >
						<div class="alert alert-light w-100 text-center mt-4 mr-4"><div class="btn btn-block btn-success">ARKADAŞ EKLE</div></div>
						<div style="overflow-y: auto; height: 250px; width: 100%">
						<table class="table">
						  <thead>
							<tr>
							  <th colspan="4" class="text-center text-info">ARKADAŞLAR</th>
							</tr>
						  </thead>
						  <tbody>
							<tr>
							  <th scope="row">1</th>
							  <td>Mark</td>
							  <td><span class="text-info">2 Yeni mesaj</span></td>
							  <td><button class="btn btn-primary btn-sm">Mesaj</button></td>
							</tr>
							<tr>
							  <th scope="row">1</th>
							  <td>Mark</td>
							  <td><span class="text-info">2 Yeni mesaj</span></td>
							  <td><button class="btn btn-primary btn-sm">Mesaj</button></td>
							</tr><tr>
							  <th scope="row">1</th>
							  <td>Mark</td>
							  <td><span class="text-info">2 Yeni mesaj</span></td>
							  <td><button class="btn btn-primary btn-sm">Mesaj</button></td>
							</tr><tr>
							  <th scope="row">1</th>
							  <td>Mark</td>
							  <td><span class="text-info">2 Yeni mesaj</span></td>
							  <td><button class="btn btn-primary btn-sm">Mesaj</button></td>
							</tr><tr>
							  <th scope="row">1</th>
							  <td>Mark</td>
							  <td><span class="text-info">2 Yeni mesaj</span></td>
							  <td><button class="btn btn-primary btn-sm">Mesaj</button></td>
							</tr><tr>
							  <th scope="row">1</th>
							  <td>Mark</td>
							  <td><span class="text-info">2 Yeni mesaj</span></td>
							  <td><button class="btn btn-primary btn-sm">Mesaj</button></td>
							</tr><tr>
							  <th scope="row">1</th>
							  <td>Mark</td>
							  <td><span class="text-info">2 Yeni mesaj</span></td>
							  <td><button class="btn btn-primary btn-sm">Mesaj</button></td>
							</tr><tr>
							  <th scope="row">1</th>
							  <td>Mark</td>
							  <td><span class="text-info">2 Yeni mesaj</span></td>
							  <td><button class="btn btn-primary btn-sm">Mesaj</button></td>
							</tr><tr>
							  <th scope="row">1</th>
							  <td>Mark</td>
							  <td><span class="text-info">2 Yeni mesaj</span></td>
							  <td><button class="btn btn-primary btn-sm">Mesaj</button></td>
							</tr>
							  
						  </tbody>
						</table>
						</div>
						
					</div>
				</div>
				
				<div class="col-7 mt-5 border-bottom border-light" style="overflow-y: scroll; height: 480px;">
				<!--Mesajların Geleceği Kısım-->
					<div class="alert alert-success w-100 text-center mx-auto">yazıyor..</div>
					
					
					<div class="w-75 alert alert-secondary ml-4 ">Merhabalar<span style="display:inline-block; float: right; font-size:10px;" class="mt-1">
						&#128348; 12:35
						</span></div>
					
					
					<div class="w-75 alert alert-primary" style="margin-left: auto; text-align: right;">AAA Merhaba<span style="display:inline-block; float: left; font-size:10px;  " class="mt-1">
						&#128348; 12:35
						</span></div>
					
					
				</div>
				
			</div>
			<div class="row mt-3 mb-3">
			
				<div class="col-5">
				
				</div>
				
				<div class="col-7">
				<input class="form-control w-100" style="margin-top: auto; height: 45px;" placeholder="Mesaj Giriniz">
				</div>
			
			</div>
			
			
			
		</div>
		
	</div>
		
		
		
		
	</div>
	

</body>
		
	
		
</html>