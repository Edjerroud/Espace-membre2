<?php

// Connection à la base de données via la création d'un objet PDO //

$pdo = new PDO('mysql:dbname=espace-membre-2;host=localhost','root','');

// Gestion des erreurs : transformer les erreurs sql en exception php //

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Format de récuperation des données : Format objet( class = stdClass ) //

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
