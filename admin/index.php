<?php 
session_start();
if (isset($_POST['rendben'])) {
    $email = strip_tags(strtolower(trim($_POST['email'])));
    $jelszo = strip_tags((trim($_POST['jelszo'])));

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z]*$/", $jelszo)) {
        $hiba = "Hibás email vagy jelszó";

    }
    else {
            if ($email == "asd@gmail.com" && $jelszo == "asd") {
                $_SESSION['belepett'] = true;
                header("Location: lista.php");
            }
            else {
                $hiba = "Hibás email vagy jelszó";            
            }
    }
    
}

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
    <h1>Belépés</h1>
    <form method="post">
        <?php if (isset($hiba)) {
            print($hiba);
        } ?>
    <p><label for="email">E-mail: </label>
    <input type="email" name="email" id="email" require></p>

    <p>
        <label for="">Jelszó: </label>
            <input type="password" name="jelszo" id="jelszo">
        
    </p>
    <input type="submit" value="Belépés" id="rendben" name="rendben">

    </form>
    
</body>
</html>