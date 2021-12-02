<h1> Restful Api </h1>


<pre>
<?php
  if(isset($_POST['buttonGet'])) { 
?><pre>
<?php
 $url = "https://gorest.co.in/public/v1/users?access-token=1ebf945a1db07f8e0a15ff80f3ed66bd8f03e3b46a301ce95d3c08af4b5e857a";
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tabla = curl_exec($ch);
 curl_close($ch);
 print_r(json_decode($tabla, JSON_PRETTY_PRINT));
?>
</pre>
    <?php }


   if(isset($_POST['buttonPost'])) {   
?><pre>
<?php
 $url = "https://gorest.co.in/public/v1/users?access-token=1ebf945a1db07f8e0a15ff80f3ed66bd8f03e3b46a301ce95d3c08af4b5e857a";
 $adatok = array(
 "name" => "Kis Kiraly",
 "email" => "kiskiraly03@data.hu",
 "gender" => "male",
 "status" => "active"
 );
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($adatok));
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tabla = curl_exec($ch);
 curl_close($ch);
 print_r(json_decode($tabla, JSON_PRETTY_PRINT));
 

?>
</pre>


Válasz:
Megkeresni az ID-t:
[id] => 2080
https://gorest.co.in/public/v1/users/2080
A most felvitt erőforrás kiíratása:
<pre>
<?php

 $url = "https://gorest.co.in/public/v1/users/2080?access-token=e474cf141b97ca9ef8d91d5859ebcb6a1a69887daa2ca51d745668a3dd152156";
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tabla = curl_exec($ch);
 curl_close($ch);
 print_r(json_decode($tabla, JSON_PRETTY_PRINT));
?>
</pre>
<?php
}





 if(isset($_POST['buttonPut'])) {  
 	?>
<pre>
<?php

 $url = "https://gorest.co.in/public/v1/users/2080?access-token=e474cf141b97ca9ef8d91d5859ebcb6a1a69887daa2ca51d745668a3dd152156";
 $adatok = array("name" => "Nagy Kiraly");
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($adatok));
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tabla = curl_exec($ch);
 curl_close($ch);
 print_r(json_decode($tabla, JSON_PRETTY_PRINT));
?>
</pre>
<?php 
}


 if(isset($_POST['buttonDelete'])) { 
?>

<pre>
<?php
 $url = "https://gorest.co.in/public/v1/users/2080?access-token=e474cf141b97ca9ef8d91d5859ebcb6a1a69887daa2ca51d745668a3dd152156";
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tabla = curl_exec($ch);
 curl_close($ch);
 print_r(json_decode($tabla, JSON_PRETTY_PRINT));
?>
</pre>

<?php
 } 
?>

    <form method="post">
        <input type="submit" name="buttonGet"
                value="GET"/>
                  <form method="post">
        <input type="submit" name="buttonPost"
                value="POST"/>
                         <form method="post">
        <input type="submit" name="buttonPut"
                value="PUT"/>
                         <form method="post">
        <input type="submit" name="buttonDelete"
                value="DELETE"/>