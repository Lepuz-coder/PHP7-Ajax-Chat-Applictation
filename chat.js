// JavaScript Document
$(document).ready(function(){
	
	$('#cik').click(function(){
	$.post("islemler.php?islem=csil");
	setTimeout(function(){
		window.location.reload();
	},1000)
	
	
})
	
	
	setInterval(function(){
		$.post("islemler.php?islem=istekguncelle",{},function(){});
		$('#frqcount').load("islemler.php?islem=arkadasistekgetir");
		$('#arkadasistekdropdown').load("islemler.php?islem=dropdownlistegetir");
		
		
	},1000)
	
	
})