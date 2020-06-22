<?php
$host = 'localhost:3306';
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

<table>
    <tr>
        <th>Naam</th>
        <th>Score Spel 1</th>
        <th>Score Spel 2</th>
        <th>Score Spel 3</th>
        <th>Score Totaal</th>
    </tr>

    <?php
    $stmt = $pdo->prepare('SELECT ID, Naam, ScoreSpel1, ScoreSpel2, ScoreSpel3 FROM scores');
    $stmt->execute([]);
    $rows = $stmt->fetchAll();

    foreach ($rows as $row) {
        echo '<tr>';
//        echo '<td>' . $row[1] . '</td>';
        echo '<td>' . $row['Naam'] . '</td>';
//        echo '<td>' . $row->Naam . '</td>';
        echo '<td>' . $row['ScoreSpel1'] . '</td>';
        echo '<td>' . $row['ScoreSpel2'] . '</td>';
        echo '<td>' . $row['ScoreSpel3'] . '</td>';
        echo '<td>' . Total($row) . '</td>';
        echo '</tr>';
    }
    ?>
</table>
</body>
</html>
