<?php

class Hir
{
	public ?string $felhasznalonev;
	public ?string $uzenet;
	public ?string $idobelyeg;
	public array   $kommentek;
	
	public function __construct(?string $felhasznalonev, ?string $uzenet, ?string $idobelyeg, array $kommentek)
	{
		$this->felhasznalonev = $felhasznalonev;
		$this->uzenet = $uzenet;
		$this->idobelyeg = $idobelyeg;
		$this->kommentek = $kommentek;
	}
	
}
class Komment
{
	public ?string $felhasznalonev;
	public ?string $szoveg;
	public ?string $idobelyeg;
	
	public function __construct(?string $felhasznalonev,?string $szoveg, ?string $idobelyeg)
	{
		$this->felhasznalonev = $felhasznalonev;
		$this->szoveg = $szoveg;
		$this->idobelyeg = $idobelyeg;
	
	}
	
	public function __toString()
	{
		return $this->felhasznalonev." ".$this->szoveg." ".$this->idobelyeg;
	/*return $this->szoveg;*/
	
	}
	
}


class Hiroldal_Model
{
	public function lekeres($vars)
	{
		
		$retData['eredmeny'] = "";
		$retData['uzenet'] = array();
		$retData['kommentek'] = array();

	try
	{
		$connection = Database::getConnection();
		$sql = "SELECT hirek.id, felhasznalok.bejelentkezes, hirek.uzenet, hirek.datum FROM hirek INNER JOIN felhasznalok ON hirek.felhaszn_id=felhasznalok.id";
		$stmt = $connection->query($sql);
		$stmt -> execute();
		$hirek = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if(count($hirek)==0)
		{
			$retData['eredmeny'] = "ERROR";
			$retData['uzenet'] = "Még nincs egy hír sem!";
		}
		else
		{
		$retData['eredmény'] = "OK";
			
			foreach($hirek as $hir)
			{
			
				$sql2 = "SELECT bejelentkezes,komment,datum2 FROM ((komment INNER JOIN felhasznalok ON komment.felhaszn_id2 = felhasznalok.id) INNER JOIN hirek ON hirek.id = komment.kommentazonosito) WHERE komment.kommentazonosito = ".$hir['id'];
				
				/*$sql2 = "SELECT komment FROM komment INNER JOIN hirek ON hirek.id = komment.kommentazonosito WHERE komment.kommentazonosito = ".$hir['id'];
				*/$stmt = $connection->query($sql2);
				$stmt -> execute();
				$kommi = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$komment_array = array();
				foreach($kommi as $kom)
				{
					
					array_push($komment_array, new Komment($kom['bejelentkezes']."<br>",$kom['komment']."<br>",$kom['datum2']."<br>"));
				}
			
				array_push($retData['uzenet'], new Hir($hir['bejelentkezes'], $hir['uzenet'], $hir['datum'], $komment_array));

			}

		Menu::setMenu();
		}

		}

	catch (PDOException $e) {
				
					$retData['uzenet'] = "Adatbázis hiba: ".$e->getMessage()."!";
		}
		return $retData;
}

public function beuszras()
{


	try
	{
		$connection = Database::getConnection();
		$datum=date("Y-m-d");

		if(isset($_POST['uzenet']))
    {


        $_POST['uzenet'] = trim($_POST['uzenet']);
	
       if($_POST['uzenet'] != "")
     {

        $sql = "insert into hirek values (0, '".$_POST['uzenet']."', '".$datum."','".$_SESSION['userid']."')";
	
       $count = $connection->query($sql);
       $newid = $connection->lastInsertId();
	   
	   header("Refresh:0");
	   
      }
    
       elseif($_POST['uzenet'] == "")
        {
       echo "Hiba: Nem adott meg tartalmat"; 
       }
       }
	}
	catch (PDOException $e) {
   echo "Hiba: ".$e->getMessage();
  }
}


public function beszuraskomment()
{
	try
	{
		$connection = Database::getConnection();
		$datum=date("Y-m-d");
		
		if(isset($_POST['komment']))
    {
		
	   $_POST['komment'] = trim($_POST['komment']);
		$_POST['tuntes'] = trim($_POST['tuntes']);
    
       $sql = "insert into komment values (0, '".$_POST['komment']."','".$_POST['tuntes']."','".$_SESSION['userid']."','".$datum."')";
       $count = $connection->query($sql);
       $newid = $connection->lastInsertId();
	   header("Refresh:0");

       }
       }
	
	catch (PDOException $e) {
   echo "Hiba: ".$e->getMessage();
  }
}

}

?>