<?php
session_start();
if (isset($_POST["pass"]) && $_POST["pass"] != "" && isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_POST["captcha"] === $_SESSION["captcha"]) {
    include '../proc/connect.php';
    $con = $GLOBALS["connect"];
    $sql = "SELECT * FROM admin WHERE `name`=? AND `pass`=?";
    $result = $con->prepare($sql);
    $hash_pass = md5($_POST["pass"]);
    $result->bindvalue(1, $_POST["username"]);
    $result->bindvalue(2, $hash_pass);
    $result->execute();
    if ($row = $result->fetchColumn()){
        $_SESSION["admin-username"] = $_POST["username"];
        $_SESSION["is-admin-login"] = "moo2017";
        header('Location: https://moovie.in/admin/panel.php');
    }


}
?>
<html>
<head>
    <title>Moovie.in Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/png" href="https://moovie.in/assets/img/favicon.png"/>

    <script src="../assets/js/bootstrap.min.js"></script>
    <style>

        /*Small devices (landscape phones, 576px and up)*/
        @media (min-width: 576px) {
            ...
        }

        /*Medium devices (tablets, 768px and up)*/
        @media (min-width: 768px) {
            ...
        }

        /*Large devices (desktops, 992px and up)*/
        @media (min-width: 992px) {
            ...
        }

        /*Extra large devices (large desktops, 1200px and up)*/
        @media (min-width: 1200px) {
            ...
        }
    </style>
</head>

<body>
<div class="container">
    <form action="" method="post">
        <div class="form-group">

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control"/>
            </div>

            <div class="form-group">
                <label for="pass">Pass:</label>
                <input type="password" name="pass" id="pass" class="form-control"/>
            </div>

            <div class="form-group">
                <label for="captcha">Code:</label>
                <img src="../proc/captcha.php" alt="">
                <input name="captcha" type="text" id="captcha" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">login</button>

        </div>
    </form>
</div>

</body>
</html>