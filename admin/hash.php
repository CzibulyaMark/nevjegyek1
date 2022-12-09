<?php 

$jelszo = "asd";
print "<p>{$jelszo}</p>";

print "<p>Jelszó: '".md5($jelszo). " </p>";

print "<p> jelszo: '". sha1($jelszo). "</p>";


?>