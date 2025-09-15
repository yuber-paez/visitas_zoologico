<?php
session_start();
require_once("../db/conection.php");
$db = new Database();
$con = $db->conectar();


if (isset($_POST["inicio"])) {

    $doc = $_POST["documento"];
    $contra = htmlentities(addslashes($_POST['password']));

    $sql = $con->prepare(query: "SELECT * FROM user WHERE doc = $doc");
    $sql->execute();
    $fila = $sql->fetch();

    if (password_verify($contra, $fila['password'])) {

        $_SESSION['id_user'] = $fila['id_user'];
        $_SESSION['type'] = $fila['id_rol'];

        if ($_SESSION['type'] == 1) {
            header("Location: ../routes/admin/index.php");
            exit();
        }
    } else {
        echo ('Usuario o contraseña incorrecto');
    }
}
