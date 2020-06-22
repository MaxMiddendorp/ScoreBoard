<?php
if (!isset($_COOKIE["ingelogd"])) {
    header("location: ../LogIn.php");
    exit();
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="Styles.css">
</head>
<body>
<?php
include "Menu.php";
?>

<h1>Welkom Admin!</h1>
<h2>Gebuik het menu om bij de admin pagina's te komen!</h2>

</body>
</html>