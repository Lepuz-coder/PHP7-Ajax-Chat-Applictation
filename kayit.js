// JavaScript Document
$(document).ready(function(){
	
	
	$('input[name="buton"]').click(function(){
		$.ajax({
			type:"POST",
			url:"islemler.php?islem=kayit",
			data:$('#kayitform').serialize(),
			success:function(donen_veri){
				$('#kayitform').trigger("reset");
				
				var sonuc = $.parseJSON(donen_veri);
				sonuc = sonuc.sonuc;
				
				switch(sonuc){
						
					case "1":
						$('#info').html('<div class="alert alert-danger">Lütfen Adı Boş Bırakmayınız</div>');
					break;
						
					case "2":
						$('#info').html('<div class="alert alert-danger">Lütfen Şifreyi Boş Bırakmayınız</div>');
					break;
						
					case "3":
						$('#info').html('<div class="alert alert-danger">Bu Kullanıcı adı zaten kullanılmakta</div>');
					break;
						
					case "4":
						$('#info').html('<div class="alert alert-success">Üyelik Başarıyla Gerçekleşti</div>');
						setTimeout(function(){
							window.location.reload();
						},2000)
					break;
						
					case "5":
						$('#info').html('<div class="alert alert-danger">Şifreler Uyuşamakta</div>');
						
					break;
				}
				
			}
			
			
		})
		
	})
	
	
	
})