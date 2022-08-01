<?php 

// Récuperation des parametres //

$user_id = $_GET['id'];
$token = $_get['token'];

// Connexion à la base de données //

require 'inc/db.php' ;

// Requete préparer //

$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');

// Execution de la requete //

$req->execute([$user_id]);

// Récuperation des informations //

$user = $req->fetch();
session_star();

// Vérification si l'utilisateur correspond et si le token correspond //

if($user && $user->confirmation_token == $token) {
    $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);
    $_SESSION['flash']['success'] = 'Votre compte a bien été validé';
    $_SESSION['auth'] = $user;
    header('Location: account.php');
}else{
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header('Location: login.php');
}
?>