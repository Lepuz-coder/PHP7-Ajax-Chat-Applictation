# CHAT APP FOR WEB WİTH PHP7 AND JAVASCRİPT
   # App's Properties :
###   1-) FRİENDS
  İn this app you can send friend request.When they accept the friend request its show on your friends list immidatetly thx for ajax.
  And if yout friends is online his name's color will be green else it will be gray.
  
  ### 2-)Chatting
   You can send message to your friends(it's not matter if they online or not) and message shown immidately on their page if they are
   online, if not they can see message when they log in.
    
   ### 3-)Sign in 
   if a user dont have any account he can sign in in signin page
   
   ### 4-)Log in
   if a user have a account he can log in and page will head him to chat part
   ## ---You will understand app's Properties clearly when you use that--
   
   # HOW I DİD ?
   
  ### 1-)WHERE I KEPP THE MESSAGE ?
   Before ı start ı wanna say ı am using ajax load method.For that ı need to load every second doesnt matter mesaage is arrive or not
    so that ı am keep the message in the txt files.Every friends message box txt files is different and when they send mesaage it will
    be added in their txt file.With this way ı can load txt files content in every second.İf ı would use the databse for messages it
    will be disaster for the server and it will be so slow.
    
  ### 2-)HOW CAN TXT FİLES KEEP THE MESSAGE ?
   I wanna show you a example in one of my txt file, 
         this txt file name is : "9c5a72cd55b705391e904af342441951bd587297.txt" and it's content is :
                        
           + Hata:Giderici,Lepuz:Naber aşkımm,Lepuz:Napıyorsun lan sen,Miray:Sanane lan,Lepuz:AAAAAA,Lepuz:o nasıl söz öyle,Miray:o biçim,
                      
 every txt files start with "Hata:Giderici" its means "Fix:Solving" it is necceseary because when it is showing in the page first message will be disappear because of my design.Anyway ı am using array algorimt so that ı am keeping message with (,:) shapes.Every user seperate with "," and users name-text is seperating with ":" shape.With explode array ı can take the users massege easily then it will be show in user page.
 There is a example : 
         ![alt text](https://github.com/Lepuz-coder/chat/blob/master/example.png)
  İn every user page his message will show in right and color is blue and text comming will show in left and color is gray.To do that in txt file ı am keeping like  "Lepuz:Naber aşkımm" that because when user connect to textbox ı need to know is user own the message or the message has came to him.I can learn that when ı explode "Lepuz:Naber aşkımm" that text ı can check user name with array's first key.Simplfy algoritm is that in chatting.
  
  ### 3-)HOW CAN I FİND THE RİGHT TXT FİLE ?
   İt is so easy.I am keeping the txt file's name in my database.And when x user add friend y user automaticalyy new txt file is creating with random name and txt file's name added in my "mesajlar" table.Also user's id will added table's 'kullaniciid' column like '2-3' there is a example of my table : 
   
  ![alt text](https://github.com/Lepuz-coder/chat/blob/master/example2.png)
  
  (token table is not important right know ı am just trying to improve api for this app)

   ### 4-)FRİEND ? 
   Friends requests is keeping in "istekler" table and user's friends list in kisiler table's 'arkadaslarid' column.
   
   ### 5-)HOW CAN YOU USE THİS APP?
   First of all dont forget the add kisiler,istekler,mesajlar table in your database and switch the dbname in php files.I mean if you decided the keep the table in 'yourdbname' named database change the codes in "islemler.php" :
   
            $db = new PDO("mysql::host=localhost;dbname=chatting;charset=utf8","root","");
            
            $db = new PDO("mysql::host=localhost;dbname=yourdbname;charset=utf8","root","");
   
            
 
    
