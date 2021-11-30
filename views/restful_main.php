<?php
$url = "http://localhost/felveteli/rest/rest.php";
$result = "";
if (isset($_POST['id'])) {
  // Felesleges szóközök eldobása
  $_POST['id'] = trim($_POST['id']);
  $_POST['nev'] = trim($_POST['nev']);
  $_POST['nem'] = trim($_POST['nem']);
  $_POST['kepzes'] = trim($_POST['kepzes']);
  $_POST['szerzett'] = trim($_POST['szerzett']);
  $_POST['sorrend'] = trim($_POST['sorrend']);


  // Ha nincs id és megadtak minden adatot, akkor beszúrás
  if (

    empty($_POST['id']) && $_POST['nev'] != "" && $_POST['nem'] != ""
    && $_POST['kepzes'] != "" && $_POST['szerzett'] != "" && $_POST['sorrend'] != ""
  ) {
    $data = array(
      "nev" => $_POST["nev"], "nem" => $_POST["nem"],
      "kepzes" => $_POST["kepzes"], "sorrend" => $_POST["sorrend"],"szerzett" => $_POST["szerzett"]

    );
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
  }

  // Ha nincs id de nem adtak meg minden adatot
  elseif ($_POST['id'] == "") {
    $result = "Hiba: Hiányos adatok!";
  }

  // Ha van id, amely >= 1, és megadták legalább az egyik adatot, akkor módosítás
  elseif (!empty($_POST['id']) && ($_POST['nev'] != "" || $_POST['nem'] != "" ||
    $_POST['kepzes'] != "" || $_POST['szerzett'] != "" || $_POST['sorrend'] != "")) {
    $data = array(
      "id" => $_POST["id"], "nev" => $_POST["nev"], "nem" => $_POST["nem"],
      "kepzes" => $_POST["kepzes"], "szerzett" => $_POST["szerzett"], "sorrend" => $_POST["sorrend"]
    );
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
  }

  // Ha van id, amely >=1, de nem adtak meg legalább az egyik adatot
  elseif (!empty($_POST['id']) && empty($_POST['nev']) && empty($_POST['nem'])) {
    $data = array("id" => $_POST["id"]);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
  
    curl_close($ch);
  }

  // Ha van id, de rossz az id, akkor a hiba kiírása
  else {
    echo "Hiba: Rossz azonosító (Id): " . $_POST['id'] . "<br>";
  }
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$tabla = curl_exec($ch);
curl_close($ch);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
</head>

<body>
  <?= $result ?>
  
  <br>
  <div class="belso">
<div class="belep">
  <form method="post" target="restful">
  <fieldset>
<legend>
  <h2>Módosítás / Beszúrás</h2></legend>
  <label for="id">  Id: <input type="text" name="id"></label><br>
  <label for="nev">Jelentkező Név: <input type="text" name="nev" maxlength="45"> </label><br>
  <label for="nem"> Nem: <input type="text" name="nem" maxlength="45"></label><br>
  <label for="kepzes"> Tantárgy: <select name="kepzes" id="kepzes"><br>
      <option></option>
      <option value="1">francia</option>
      <option value="2">angol</option>
      <option value="3">matematika</option>
      <option value="4">informatika</option>
      <option value="5">környezetvédelmi</option>
      <option value="6">közgazdasági</option>
    </select></label><br>
    <label for="szerzett">Pontszám:<input type="text" name="szerzett" maxlength="45"></label><br>
    <label for="sorrend"> Sorrend:<input type="text" name="sorrend" maxlength="45"></label><br>
    <input type="submit" value="Küldés">
    </fieldset>
  </form>
</div>
  <h1>Jelentkezők:</h1>
 <?= $tabla ?> 
 </div>

</body>

</html>