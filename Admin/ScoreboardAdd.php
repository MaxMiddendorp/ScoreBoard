<?php
if (!isset($_COOKIE["ingelogd"])) {
    header("location: ../LogIn.php");
    exit();
}

$host = 'localhost';
$db = 'Scoreboard';
$user = 'site';
$pass = 'SitePassword-1';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard</title>
    <link rel="stylesheet" type="text/css" href="Styles.css">

</head>
<body>

<?php
include "Menu.php";
function Total($row) {
    return $row["ScoreSpel1"] + $row["ScoreSpel2"] + $row["ScoreSpel3"];
}

?>

<form action="ScoreboardAdd.php" method="post">
    Naam: <input type="text" name="naam"><br>
    <input type="submit">
</form>

<?php
if (count($_POST) == 1) {
    $naam = $_POST["naam"];
    $stmt = $pdo->prepare("INSERT INTO scores (Naam) VALUES (?)");
    $stmt->execute([$naam]);
    echo $naam . " is toegevoegd aan het scoreboard";
}
?>
</body>
</html>
