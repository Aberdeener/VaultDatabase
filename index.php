<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://www.vaultmc.net/favicon.ico" type="image/png">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-rCA2D+D9QXuP2TomtQwd+uP50EHjpafN+wruul0sXZzX/Da7Txn4tB9aLMZV4DZm" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet">
    <title>VaultMC - Database</title>
</head>

<body>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require 'mojangAPI/mojang-api.class.php';
    include 'config.php';
    include 'includes/navbar.php';
    include 'functions.php';
    ?>

    <div class="container-fluid">

        <?php if (isset($_SESSION["timezone"])) {
            $timezone = $_SESSION["timezone"];
        } else {
            $timezone = "null";
        } ?>

        <br>

        <?php
        $actions = array(
            'home',
            'search',
            'user',
            'clan'
        );

        if (isset($_GET['action']) && in_array($_GET['action'], $actions)) {
            include("actions/" . $_GET['action'] . '.php');
        } else if (isset($_GET['page']) && in_array($_GET['page'], $pages)) {
            include("pages/" . $_GET['page'] . '.php');
        } else {
            header('Location: https://database.vaultmc.net/?action=home');
            exit;
        }
        ?>
    </div>

    <?php include 'includes/footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>