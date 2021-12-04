<?php
class Felveteli_Model
{
    public array $kepzes;
    public array $jelentkezes;
    public array $jelentkezo;

    public function __construct()
    {
        $this->kepzes = array();
        $this->jelentkezes = array();
        $this->jelentkezo = array();
    }

    // public function __construct(array $kepzes, array $jelentkezes, array $jelentkezo)
    // {
    //     $this->kepzes = $kepzes;
    //     $this->jelentkezes = $jelentkezes;
    //     $this->jelentkezo = $jelentkezo;
    // }

    public function read_from_db()
    {
        try {
            $connection = Database::getConnection();
            $sql = "SELECT jelentkezes.id as id, jelentkezes.jelentkezoid as jelentkezoid, kepzes.id as kepzesid, jelentkezo.nev as jelnev, jelentkezo.nem, kepzes.nev as kepzesnev, kepzes.felveheto, kepzes.minimum FROM jelentkezes INNER JOIN jelentkezo  ON jelentkezo.id = jelentkezes.jelentkezoid INNER JOIN kepzes ON kepzes.id = jelentkezes.kepzesid GROUP BY jelentkezes.id;";
            $stmt = $connection->query($sql);
            $stmt->execute();
            $felveteli = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($felveteli as $jelentkezes) {
                array_push($this->jelentkezes, array('id' => $jelentkezes['id'], 'jelentkezoid' => $jelentkezes['jelentkezoid']));
                array_push($this->kepzes, array('id' => $jelentkezes['kepzesid'], 'nev' => $jelentkezes['kepzesnev'], 'felveheto_diakok_szama' => $jelentkezes['felveheto'], 'minimum_pont' => $jelentkezes['minimum']));
                array_push($this->jelentkezo, array('id' => $jelentkezes['jelentkezoid'], 'nev' => $jelentkezes['jelnev'], 'nem' => $jelentkezes['nem']));
            }
        } catch (PDOException $e) {

            $retData['uzenet'] = "Adatbázis hiba: " . $e->getMessage() . "!";
        }
    }

    // public function get_jelentkezes_json()
    // {
    //     $connection = Database::getConnection();
    //     $sql = "SELECT  DISTINCT nev FROM kepzes;";
    //     $stmt = $connection->query($sql);
    //     $stmt->execute();
    //     $kepzesek = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     echo json_encode($kepzesek);
    // }

    public function get_kepzes_json()
    {
        // echo json_encode($this->kepzes, JSON_UNESCAPED_UNICODE);
        $connection = Database::getConnection();
        $sql = "SELECT DISTINCT nev FROM kepzes;";
        $stmt = $connection->query($sql);
        $stmt->execute();
        $kepzesek = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($kepzesek, JSON_UNESCAPED_UNICODE);
    }

    public function get_nem_json()
    {
        $connection = Database::getConnection();
        $sql = "SELECT DISTINCT nem FROM jelentkezo;";
        $stmt = $connection->query($sql);
        $stmt->execute();
        $nemek = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($nemek, JSON_UNESCAPED_LINE_TERMINATORS);
    }

    public function get_sorrend_json()
    {
        $connection = Database::getConnection();
        $sql = "SELECT DISTINCT sorrend FROM jelentkezes;";
        $stmt = $connection->query($sql);
        $stmt->execute();
        $sorrend = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($sorrend, JSON_UNESCAPED_LINE_TERMINATORS);
    }

    //     public function get_jelentkezo_json()
    //     {
    //         echo json_encode($this->jelentkezo);
    //     }
}

class Kepzes
{
    public $id;
    public $nev;
    public $felveheto_diakok_szama;
    public $minimum_pont;

    public function __construct($id, $nev, $felveheto_diakok_szama, $minimum_pont)
    {
        $this->id = $id;
        $this->nev = $nev;
        $this->felveheto_diakok_szama = $felveheto_diakok_szama;
        $this->minimum_pont = $minimum_pont;
    }
}

class Jelentkezes
{
    public $id;
    public $jelentkezoid;
    public $kepzesid;

    public function __construct($id, $jelentkezoid, $kepzesid)
    {
        $this->id = $id;
        $this->jelentkezoid = $jelentkezoid;
        $this->kepzesid = $kepzesid;
    }
}

class Jelentkezo
{
    public $id;
    public $nev;
    public $nem;

    public function __construct($id, $nev, $nem)
    {
        $this->id = $id;
        $this->nev = $nev;
        $this->nem = $nem;
    }
}
