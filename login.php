<?php
session_start();
//session_destroy();
require_once("model.php");

$users_list = getUsers($db_media);
$admin_name = $users_list[0][0];
$admin_pwd = $users_list[0][1];

$action = "";

if (isset($_SESSION['password'])) {
    $login_ok = true;
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
}
else {
    if (isset($_POST["login"])) {
        $action = $_POST["login"];
        $username = $_POST["username"];
        $password = $_POST["password"];
    }
    $login_ok = false;
}

switch ($action) {
    case "Login" :
        if ($username == $admin_name && $password == $admin_pwd) {
            $login_ok = true;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
        }
        break;
}

if ($login_ok == true) {
    require_once('controller.php');
}
else {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médiathèque | PROFORMA</title>

    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    

    <link rel="stylesheet" href="src/css/normalize.css">
    <link rel="stylesheet" href="src/css/main.css">
</head>
<body>
        <form method="POST" action="login.php">
            <section id='login'>
                <h2>Connexion<hr></h2>
                <fieldset>
                    <label for="id-username">Nom d'utilisateur</label><br>
                    <input type="text" name="username" id="id-username" placeholder="Votre pseudo..." required><br><br>
                    <label for="id-password">Mot de passe</label><br>
                    <input type="password" name="password" id="id-password" placeholder="Mot de passe" required><br><br>
                    <button type="submit" name='login' value='Login'>Connexion</button>
                </fieldset>
            </section>
        </form>
        <div class='wave'>
            <div class='air air1'></div>
            <div class='air air2'></div>
            <div class='air air3'></div>
            <div class='air air4'></div>
        </div>
        <footer>
            <p class="footer-text"><i class="fa-regular fa-copyright"></i> | Thomas Stassart</p>
        </footer>
    <script src="src/js/stars.js"></script>
    <script src="https://kit.fontawesome.com/1905ce4e1a.js" crossorigin="anonymous"></script>
</body>
</html>
<?php
}
?>