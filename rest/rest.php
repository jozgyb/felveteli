<?php
$eredmeny = "";
try {
    $dbh = new PDO(
        'mysql:host=localhost;dbname=web2',
        'root',
        '',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            $eredmeny = array();
            $sql = "SELECT  jelentkezo.id as id, jelentkezo.nev as nev, jelentkezo.nem as nem FROM  jelentkezo ORDER BY jelentkezo.id desc";
            $sth = $dbh->query($sql);
            echo "<table class='tabla' style=\"border-collapse: collapse;\"><tr><th style='text-align: center;'>Jelentkező id</th><th style='text-align: center;'>Jelentkező Név</th><th style='text-align: center;'>Jelentkező Nem</th></tr>";
            echo "<tr>";
            while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

                foreach ($row as $column) {
                    // $eredmeny .= "<tr>";
                    echo  "<td style=\"border: 1px solid black; padding: 3px;\">" . $column . "</td>";

                    //$eredmeny .= "</tr>";".$column."</td></tr>";
                    // $eredmeny .= "</tr>";
                }
                echo "</tr>";

                //array_push($eredmeny, new Segitseg($row['jelnev'], $row['nem'], $row['knev']));
            }


            echo "</table>";
            break;
        case "POST":
            $i = 901;
            $leker="";
            $sql = "INSERT INTO jelentkezo values (0, :nev, :nem)";
         
            $sth = $dbh->prepare($sql);
            $conemt = $sth->execute(array(":nev" => $_POST["nev"], ":nem" => $_POST["nem"]));
         
            $newid = $dbh->lastInsertId();
            $eredmeny .= $conemt . " beszúrt sor: " . $newid;
            $i++;
            break;
        case "PUT":
            $data = array();
            $incoming = file_get_contents("php://input");
            parse_str($incoming, $data);
            $modositando = "id=id";
            $params = array(":id" => $data["id"]);

            if ($data['nev'] != "") {
                $modositando .= ", nev = :nev";
                $params[":nev"] = $data["nev"];
            }
            if ($data['nem'] != "") {
                $modositando .= ", nem = :nem";
                $params[":nem"] = $data["nem"];
            }
            $sql = "UPDATE jelentkezo set " . $modositando . " WHERE id=:id";
            $sth = $dbh->prepare($sql);
            $conemt = $sth->execute($params);
            $eredmeny .= $conemt . " módositott sor. Azonosítója:" . $data["id"];

            break;
        case "DELETE":
            $data = array();
            $incoming = file_get_contents("php://input");
            parse_str($incoming, $data);
            $sql =  "DELETE FROM jelentkezo WHERE id=:id";
          
            $sth = $dbh->prepare($sql);
            $conemt = $sth->execute(array(":id" => $data["id"]));
          

            $eredmeny .= $conemt . " sor törölve. Azonosítója:" . $data["id"];
            break;
    }
} catch (PDOException $e) {
    $eredmeny = $e->getMessage();
}
return $eredmeny;
