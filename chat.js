// JavaScript Document
$(document).ready(function(){
	
	$('#cik').click(function(){//Çıkış butonu için
	$.post("islemler.php?islem=csil");
	setTimeout(function(){
		window.location.reload();
	},1000);
	
	
});
	
	
})