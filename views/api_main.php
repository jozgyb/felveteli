<div class="rendez">
        <form method="post">
                <input type="submit" class="api" name="gombget" value="Lekérdezés" />
                <input type="submit" class="api" name="gombpost" value="Beszúrás" />

                <input type="submit" class="api" name="gombput" value="Módosítás" />

                <input type="submit" class="api" name="gombtorles" value="Törlés" />
        </form>
</div>
<?php
if (isset($_POST['gombget'])) {
        $url = "https://gorest.co.in/public/v1/posts?access-token=b0510476761951d379e4f092784758d5ea6b432000616b7f2a2cfe5c23822e4c";


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tabla = curl_exec($ch);
        curl_close($ch);
        //print_r(json_decode($tabla, JSON_PRETTY_PRINT));
        echo "<pre>";
        print_r(json_decode($tabla, true));
        echo "</pre>";

        //  $get_result = json_decode($tabla, true);
}
if (isset($_POST['gombpost'])) {
        $url = "https://gorest.co.in/public/v1/posts?access-token=b0510476761951d379e4f092784758d5ea6b432000616b7f2a2cfe5c23822e4c";



        $adatok = array(
                "user_id" => "2791",
                "title" => "Tanár úr beszúrás",
                "body" => "Ezt a sort szúrta be a tanár úr"
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($adatok));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tabla = curl_exec($ch);
        curl_close($ch);

?>
        <pre><?php
                print_r(json_decode($tabla, JSON_PRETTY_PRINT)); ?>
                
                Válasz:
                Megkeresni az ID-t:
                [id] => 1471
                https://gorest.co.in/public/v1/users/1471
                A most felvitt erőforrás kiíratása:
                </pre><?php
                        $url = "https://gorest.co.in/public/v1/posts/1471?access-token=b0510476761951d379e4f092784758d5ea6b432000616b7f2a2cfe5c23822e4c";


                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $tabla = curl_exec($ch);
                        curl_close($ch);
                        print_r(json_decode($tabla, JSON_PRETTY_PRINT));
                        ?>
        <pre><?php
                print_r(json_decode($tabla, JSON_PRETTY_PRINT));
                ?></pre><?php
                }





                if (isset($_POST['gombput'])) {
                        $url = "https://gorest.co.in/public/v1/posts/1471?access-token=b0510476761951d379e4f092784758d5ea6b432000616b7f2a2cfe5c23822e4c";


                        $adatok = array(

                                "user_id" => "2791",
                                "title" => "Tanár úr módosítás",
                                "body" => "A tanár úr ezt a sort módosította"

                        );
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($adatok));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $tabla = curl_exec($ch);
                        curl_close($ch);
                        print_r(json_decode($tabla, JSON_PRETTY_PRINT));
                }


                if (isset($_POST['gombtorles'])) {
                        $url = "https://gorest.co.in/public/v1/posts/1471?access-token=b0510476761951d379e4f092784758d5ea6b432000616b7f2a2cfe5c23822e4c";


                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $tabla = curl_exec($ch);
                        curl_close($ch);
                        echo "<pre>";
                        print_r(json_decode($tabla, JSON_PRETTY_PRINT));
                        print_r("A tanár úr ezt a sort törölte! ID: 1471");
                        echo "</pre>";
                }
                        ?>