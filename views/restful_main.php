<?php
$url = "http://localhost/felveteli/rest/rest.php";
$result = "";
if (isset($_POST['id'])) {
  // Felesleges szóközök eldobása
  $_POST['id'] = trim($_POST['id']);
  $_POST['nev'] = trim($_POST['nev']);
  $_POST['nem'] = trim($_POST['nem']);



  // Ha nincs id és megadtak minden adatot, akkor beszúrás
  if (

    empty($_POST['id']) && $_POST['nev'] != "" && $_POST['nem'] != ""

  ) {
    $data = array(
      "nev" => $_POST["nev"], "nem" => $_POST["nem"]


    );
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
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
  elseif (!empty($_POST['id']) && ($_POST['nev'] != "" || $_POST['nem'] != "")) {
    $data = array(
      "id" => $_POST["id"], "nev" => $_POST["nev"], "nem" => $_POST["nem"]
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
            <h2>Módosítás / Beszúrás / Törlés</h2>
          </legend>
          <label for="id"> Id: <input type="text" name="id"></label><br>
          <label for="nev">Jelentkező Név: <input type="text" name="nev" maxlength="45"> </label><br>
          <label for="nem"> Nem: <input type="text" name="nem" maxlength="45"></label><br>

          <input type="submit" class="kul" value="Küldés">
        </fieldset>
      </form>
    </div>
    <p style="color: #158FAD;">Ha id kívül minden adatot megad beszúrás történik.</p>
    <p style="color: #158FAD;">Ha megadja az id és egy másik adatot módosítás történik.</p>
    <p style="color: #158FAD;">Ha csak az id adja meg töröl.</p>
    <h1 style="text-align: center;color: #158FAD;margin: 10px 0;">Jelentkezők</h1>
    <?= $tabla ?>
 <?= $tabla ?> 
    <?= $tabla ?>
  </div>

</body>

</html>