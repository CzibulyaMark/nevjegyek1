<?php
session_start();
if (!isset($_SESSION['belepett'])) {
    header("Location: false.html");
    exit();
}
if (isset($_POST['rendben'])) {
    $nev = strip_tags(trim(ucwords($_POST['nev'])));
    print_r($nev);

    $cegnev = strip_tags(trim(strtoupper($_POST['cegnev'])));
    print_r($cegnev);

    $mobil = strip_tags(trim(($_POST['mobil'])));
    print_r($mobil);

    $email = strip_tags(trim(strtolower($_POST['email'])));
    print_r($email);

    $mime = array('image/jpeg', 'image/gif', 'image/png');

    if (empty($nev)) {
        $hibak[] = "Nem adott meg nevet";
        
    } elseif (strlen($nev) < 3) {
        $hibak[] = "Túl rövid nevet adott meg!";
    }
    if (!empty($mobil) && strlen($mobil) < 6) {
        $hibak[] = "hibas mobilszam";
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hibak[] = "Email helytelen";
    }
    if ($_FILES['foto']['error'] == 0 && $_FILES['foto']['size'] > 2000000) {
        $hibak[] = "kep tul nagy";
    }
    if ($_FILES['foto']['error'] == 0 && !in_array($_FILES['foto']['type'], $mime)) {
        $hibak[] = "kep nem jo";
    }
    print_r($hibak);

    switch ($_FILES['foto']['type']) {
        case 'image/png':
            $kit = ".png";
            break;

        case 'image/gif':
            $kit = ".gif";
            break;

        case 'image/jpg':
            $kit = ".jpg";
            break;

        default:
            $kit = ".jpg";
            break;
    }
    $foto = date("U") . $kit;

    if (isset($hibak)) {
        $kimenet = "<ul>\n";
        foreach ($hibak as $hiba) {
            $kimenet .= "<li>{$hiba}</li>";
        }
        $kimenet .= "</ul>";
    } else {
        require("../kapcsolat.php");
        $sql = "INSERT INTO nevjegyek (foto,nev,cegnev,mobil,email)
        VALUES('{$foto}','{$nev}','$cegnev','{$mobil}','{$email}')
        
        ";
        mysqli_query($dbconn, $sql);
        

        move_uploaded_file($_FILES['foto']['tmp_name'], "../kepek/{$foto}");
        header("Location:lista.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Új nevjegy fevetele</h1>

    <form method="post" enctype="multipart/form-data">

        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
        <p><label for="foto">Fotó feltöltése</label></p>
        <p><input type="file" name="foto" id="foto"></p>

        <p><label for="nev">Név*:</label>
            <input type="text" name="nev" id="nev" value="">
        </p>

        <p><label for="cegnev">CegNév*:</label>
            <input type="text" name="cegnev" id="cegnev" value="">
        </p>

        <p><label for="mobil">Mobil*:</label>
            <input type="tel" name="mobil" id="mobil" value="">
        </p>

        <p><label for="email">Email*:</label>
            <input type="email" name="email" id="email" value="">
        </p>

        <p><em>A *-al jelölt mezők kitöltése kötelezőő</em></p>

        <input type="submit" value="Rendben" id="rendben" name="rendben">
        <input type="reset" value="Mégsem">
        <p><a href="lista.php">Viszza</a></p>

    </form>
</body>

</html>