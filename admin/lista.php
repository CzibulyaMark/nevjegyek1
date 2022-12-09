<?php 
session_start();
if (!isset($_SESSION['belepett'])) {
    header("Location: false.html");
    exit();
}
require("kapcsolat.php");
$rendez = (isset($_GET['rendez'])) ? $_GET['rendez'] : "nev";
$kifejezes = (isset($_POST['kifejezes'])) ? $_POST['kifejezes'] : "";
$sql = "SELECT*
FROM nevjegyek
WHERE (
    nev LIKE '%{$kifejezes}%'
    OR cegnev LIKE '%{$kifejezes}%'
    OR mobil LIKE '%{$kifejezes}%'
    OR email LIKE '%{$kifejezes}%'
)
ORDER BY {$rendez} ASC";
$eredmeny = mysqli_query($dbconn, $sql);

$kimenet = "
<table>
    <tr>
        <th>foto</th>
        <td><a href=\"?rendez=nev\">Név</a></td>
        <td><a href=\"?rendez=cegnev\">cegNév</a></td>
       
        <th>Mobil</th>
        <th>Email</th>
        <th>Műveletek</th>
        
    </tr>";

    while ($sor = mysqli_fetch_assoc($eredmeny)) {
        $kimenet.= "
        <tr>
        <td><img src=\"../kepek/{$sor['foto']}\" alt=\"{$sor['foto']}\"></td>
        <td>{$sor['nev']}</td>
        <td>{$sor['cegnev']}</td>
        <td>{$sor['mobil']}</td>
        <td>{$sor['email']}</td>
        <td><a href=\"torles.php? id= {$sor['id']}\">Törlés</a> | <a href=\"modositas.php? id= {$sor['id']}\">Módosítás</a></td>
        
        </tr>
        
        
        ";
    }
    $kimenet .= "
    </table>
    ";
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Document</title>
</head>
<body>
    
    <h1>nevjegyek</h1>


    <form method="post">
        <input type="search" name="kifejezes" id="kifejezes">
    </form>
    <p><a href="felvetel.php">Új névjegy felvétele</a</p>
    
    <?php 
      print_r($kimenet);
    ?>


</body>
</html>