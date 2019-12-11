// JavaScript Document
$(document).ready(function(){
	$('input[name="buton"]').click(function(){
			
			$.ajax({
				type:"POST",
				url:"islemler.php?islem=giris",
				data:$('#kayitForm').serialize(),
				success: function(donen_veri){
					$('#kayitForm').trigger("reset");
					
					var veri = $.parseJSON(donen_veri);
					
					$('#sonuc').html(veri.sonuc);
					
				}
				
				
			})
		
	})
	
})