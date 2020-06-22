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

if (count($_POST) == 1) {
    // add_#id#_1/2/3
    // rem_#id#_1/2/3
    $action = $_POST["action"];
    $id = (substr($action, 4, strlen($action) - 6));
    $column = (substr($action, -1, 1));
    // UPDATE scores SET ScoreSpel1 = ScoreSpel1 + 1 WHERE ID='8'
    $SQL = 'UPDATE scores SET ScoreSpel' . $column . ' = ScoreSpel' . $column . ' ';
    if (substr($action, 0, 3) == "add") {
        $SQL .= '+';
    } elseif (substr($action, 0, 3) == "rem") {
        $SQL .= '-';
    }
    $SQL .= ' 1 WHERE ID=?';
    $stmt = $pdo->prepare($SQL);
    $stmt->execute([$id]);
    if ($stmt->rowCount() == 0) {
        echo "score update niet gelukt";
    } else {
        echo 'score geupdated';
    }
}
?>
<form action="ScoreboardAdmin.php" method="post">
    <table>
        <tr>
            <th>Naam</th>
            <th colspan="3">Score Spel 1</th>
            <th colspan="3">Score Spel 2</th>
            <th colspan="3">Score Spel 3</th>
            <th>Score Totaal</th>
        </tr>

        <?php
        $stmt = $pdo->prepare('SELECT ID, Naam, ScoreSpel1, ScoreSpel2, ScoreSpel3 FROM scores');
        $stmt->execute([]);
        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {
            echo PHP_EOL . '<tr>';
//        echo '<td>' . $row[1] . '</td>';
            echo '<td>' . $row['Naam'] . '</td>';
//        echo '<td>' . $row->Naam . '</td>';
            echo '<td>' . $row['ScoreSpel1'] . '</td>';
            echo '<td>' . '<button type="submit" name="action" value="add_' . $row["ID"] . '_1">+</button>' . '</td>';
            echo '<td>' . '<button type="submit" name="action" value="rem_' . $row["ID"] . '_1">-</button>' . '</td>';
            echo '<td>' . $row['ScoreSpel2'] . '</td>';
            echo '<td>' . '<button type="submit" name="action" value="add_' . $row["ID"] . '_2">+</button>' . '</td>';
            echo '<td>' . '<button type="submit" name="action" value="rem_' . $row["ID"] . '_2">-</button>' . '</td>';
            echo '<td>' . $row['ScoreSpel3'] . '</td>';
            echo '<td>' . '<button type="submit" name="action" value="add_' . $row["ID"] . '_3">+</button>' . '</td>';
            echo '<td>' . '<button type="submit" name="action" value="rem_' . $row["ID"] . '_3">-</button>' . '</td>';
            echo '<td>' . Total($row) . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</form>

</body>
</html>
