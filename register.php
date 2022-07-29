<?php require_once 'inc/functions.php'; ?>
<?php require_once 'inc/header.php'; ?>

<?php  

// Vérification si les données ont été posté //
if(!empty($_POST)) {

    $errors = array() ;
    require_once 'inc/db.php';

 
// Vérification du nom d'utilisateur //

    if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
        $errors['username'] = "Votre pseudo n'est pas valide (alphanumerique)";

    }else{

// Requete préparé //

        $req = $pdo->prepare('SELECT id FROM users WHERE username = ?');

// Execution de la requete //

        $req->execute([$_POST['username']]);

// Récuperation des informations //

        $user = $req->fetch();
        
        if($user){
            $errors['username'] = 'Ce pseudo est déja pris';
        }
    }

// Vérification de l'email //

    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Votre email n'est pas valide ";

    }else{

        $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        
        if($user){
            $errors['email'] = 'Cet email est déja utilisé pour un autre compte';
        }
    }

// Vérification du mot de passe et de la confirmation du mot de passe //

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $errors['password'] = "Vous devez rentrer un mot de passe valide";
    }
    
    if(empty($errors)){

        
        
        $req = $pdo->prepare("INSERT INTO users SET `username` = ?, `email` = ?, `password` = ?, `confirmation_token` = ?");
        $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
        $token = str_random(60);
        // debug($token);
        // die();
        $req->execute([$_POST['username'], $_POST['email'], $password, $token]);
        $user_id = $pdo->lastInsertId();
        mail($_POST['email'], 'confirmmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/Espace-membre-php-2/confirm.php?id=$user_id &token=$token");
        header('location: login.php');
        exit();
        
        
        
    }

// Fonction debug //

    debug($errors);
}

?>





<h1>S'inscrire</h1>

<?php if(!empty($errors)): ?>

<div class="alert alert-danger">
    <p>Vous n'avez pas rempli le formulaire correctement</p>
    <ul>
    <?php foreach($errors as $error): ?>
        <li><?= $error; ?></li>
    <?php endforeach; ?>
    </ul>   
</div>
<?php endif; ?>

<!--------------------------------- FORMULAIRE ------------------------------------------------------->

<form action="" method="POST">

    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" name="username" class="form-controle" />
    </div>

    <div class="form-group">
        <label for="">Email</label>
        <input type="text" name="email" class="form-control" />
    </div>

    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control" />
    </div>

    <div class="form-group">
        <label for="">Confirmez votre mot de passe</label>
        <input type="password" name="password_confirm" class="form-control" />
    </div>

    <button type="submit" class="btn btn-primary">M'inscrire</button>

</form>
<?php require 'inc/footer.php'; ?>