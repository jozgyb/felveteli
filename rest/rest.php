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
            $sql = "SELECT jelentkezo.id ,jelentkezes.jelentkezoid as id2,jelentkezo.nev as nev, jelentkezo.nem , kepzes.nev as kepzes, jelentkezes.sorrend , jelentkezes.szerzett FROM (( jelentkezo INNER JOIN jelentkezes ON jelentkezo.id = jelentkezes.id ) INNER JOIN kepzes ON jelentkezes.kepzesid = kepzes.id) GROUP BY jelentkezes.id;";
            $sth = $dbh->query($sql);
            echo "<table style=\"border-collapse: collapse;\"><tr><th>Jelentkező név</th><th>Nem</th><th>Jelentkezés</th><th>Jelentkezés</th></tr>";
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
            $sql = "INSERT INTO jelentkezo values (0, :nev, :nem)";
            $sql2 = "INSERT INTO jelentkezes values (0,:$i,:kepzes, :sorrend, :szerzett)";
            $sth = $dbh->prepare($sql);
            $conemt = $sth->execute(array(":nev" => $_POST["nev"], ":nem" => $_POST["nem"]));
            $sth2 = $dbh->prepare($sql2);
            $conemt2 = $sth2->execute(array(":id" => $_POST["id"], ":kepzes" => $_POST["kepzes"], ":sorrend" => $_POST["sorrend"], ":szerzett" => $_POST["szerzett"]));
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

            if ($data['kepzes'] != "") {
                $modositando .= ", kepzes = :kepzes";
                $params[":kepzes"] = $data["kepzes"];
            }
            
            if ($data['sorrend'] != "") {
                $modositando .= ", sorrend = :sorrend";
                $params[":sorrend"] = $data["sorrend"];
           }
  
            if ($data['szerzett'] != "") {
                $modositando .= ", szerzett = :szerzett";
                $params[":szerzett"] = $data["szerzett"];
            }
           
            $sql2 = "UPDATE jelentkezes set " . $modositando . " WHERE jelentkezoid=:id";
           
            $sth2 = $dbh->prepare($sql2);
           $conemt2 = $sth2->execute($params);
           var_dump($params);
          
        
    
           
        
            $eredmeny .= $conemt2 . " módositott sor. Azonosítója:" . $data["id"];
            break;
        case "DELETE":
            $data = array();
            $incoming = file_get_contents("php://input");
            parse_str($incoming, $data);
            $sql =  "DELETE FROM jelentkezes WHERE jelentkezoid=:id";
            $sql2 =  "DELETE FROM jelentkezo WHERE id=:id";
            $sth = $dbh->prepare($sql);
            $conemt = $sth->execute(array(":id" => $data["id"]));
            $sth2 = $dbh->prepare($sql2);
            $conemt2 = $sth2->execute(array(":id" => $data["id"]));

            $eredmeny .= $conemt . " sor törölve. Azonosítója:" . $data["id"];
            break;
    }
} catch (PDOException $e) {
    $eredmeny = $e->getMessage();
}
return $eredmeny;
