
<?php
 $url = "https://gorest.co.in/public/v1/posts?access-token=b0510476761951d379e4f092784758d5ea6b432000616b7f2a2cfe5c23822e4c";

  if(isset($_POST['gomget'])) { 



 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tabla = curl_exec($ch);
 curl_close($ch);
 print_r(json_decode($tabla, JSON_PRETTY_PRINT));
}


   if(isset($_POST['gombpost'])) {   


 $adatok = array(
 "id" => "1",
 "user_id" => "23",
 "title" => "Változtatt",
 "body" => "bejegyzés átírása"
 );
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($adatok));
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tabla = curl_exec($ch);
 curl_close($ch);
 print_r(json_decode($tabla, JSON_PRETTY_PRINT));
 






;
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tabla = curl_exec($ch);
 curl_close($ch);
 print_r(json_decode($tabla, JSON_PRETTY_PRINT));

}





 if(isset($_POST['gombput'])) {  
 	


 $adatok = array("body" => "Nagy Kiraly");
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($adatok));
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tabla = curl_exec($ch);
 curl_close($ch);
 print_r(json_decode($tabla, JSON_PRETTY_PRINT));
 
}


 if(isset($_POST['gomtorles'])) { 


 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tabla = curl_exec($ch);
 curl_close($ch);
 print_r(json_decode($tabla, JSON_PRETTY_PRINT));




 } 
?>

    <form method="post">
        <input type="submit" name="gomget"
                value="Lekérdez"/>
                  <form method="post">
        <input type="submit" name="gombpost"
                value="Beszúrás"/>
                         <form method="post">
        <input type="submit" name="gombput"
                value="Módosítás"/>
                         <form method="post">
        <input type="submit" name="gomtorles"
                value="Törlés"/>