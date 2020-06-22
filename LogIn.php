<?php
if (isset($_COOKIE["ingelogd"])) {
    header("location: /Admin/Admin.php");
    exit();
}
session_start();
$host = 'localhost';
$db = 'UserBoard';
$user = 'site';
$pass = 'SitePassword-1';
$charset = 'utf8mb4';

try {
    $connect = new PDO("mysql:host=$host; dbname=$db", $user, $pass);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST["login"])) {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $message = '<label>Vul alle velden in</label>';
        } else {
            $query = "SELECT * FROM users WHERE username = :username AND password = :password";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    'username' => $_POST["username"],
                    'password' => $_POST["password"]
                )
            );
            $count = $statement->rowCount();
            if ($count > 0) {
                $_SESSION["username"] = $_POST["username"];
                header("location: Admin/Admin.php");
                $cookie_name = "ingelogd";
                $cookie_value = $_POST["username"];
                setcookie($cookie_name, $cookie_value, time() + 3600);
            } else {
                $message = '<label>Foute log-in informatie</label>';
            }
        }
    }
} catch (PDOException $error) {
    $message = $error->getMessage();
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="Admin/Styles.css">
</head>
<body>
<?php
include "Menu.php";
?>

<div class="container" style="width:500px;">
    <?php
    if (isset($message)) {
        echo '<label class="text-danger">' . $message . '</label>';
    }
    ?>
    <h3 align="">Log in!</h3><br/>
    <form method="post">
        <label>Gebruikersnaam</label>
        <input type="text" name="username" class="form-control"/>
        <br/>
        <label>Wachtwoord</label>
        <input type="password" name="password" class="form-control"/>
        <br/>
        <input type="submit" name="login" class="btn btn-info" value="Login"/>
    </form>
</div>
</body>
</html>
