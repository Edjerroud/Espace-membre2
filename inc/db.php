<?php

$pdo = new PDO('mysql:dbname=espace-membre-2;host=localhost','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

// $bdd = new PDO('mysql:host=localhost;dbname=espace_membre','root','');